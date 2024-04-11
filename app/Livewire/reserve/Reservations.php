<?php

namespace App\Livewire\reserve;

use Livewire\Component;
use App\Models\FoodListing;

use App\Models\Reservation;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovedReservationEmail;
use App\Livewire\Application\ApplicationComponent;

class Reservations extends Component
{
    public $food_listing_id;
    public $showModal = false;
    public $isApplicationApproved = false;
    public $previousUncollected = 5;

    public function toggleModal($status)
    {
        $this->showModal = $status;
        $this->dispatch('toggleModal', ['status' => $this->showModal]);
    }

    public function mount($food_listing_id)
    {
        $this->food_listing_id = $food_listing_id;
        $user = Auth::user();
        $userApplication = $user->application ?? null;
        $this->isApplicationApproved = $user->hasRole('admin') || ($userApplication && $userApplication->status === 'approved');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('modal-closed');
    }

    public function render()
    {
        $foodListings = FoodListing::all();
        $reservations = Reservation::with(['user', 'foodListing'])->latest()->get();

        return view('livewire.reservation.reservations', [
            'foodListings' => $foodListings,
            'reservations' => $reservations,
            'showMessage' => $this->isApplicationApproved,
        ]);
    }

    public function reserve()
    {
        $user = Auth::user();

        if (!$this->isApplicationApproved) {
            $this->dispatch('modal-message', [
                'type' => 'error',
                'message' => 'Please ensure your application is approved before making a reservation.'
            ]);
            return;
        }

        $uncollectedRes = Reservation::where('user_id', $user->id)->where('hasCollected', false)->count();

        if ($uncollectedRes >= $this->previousUncollected) {
            session()->flash('error', 'You have too many uncollected reservations. Please contact support.');
            return;
        }

        if (!Auth::user()->hasRole('admin') && (!$user->application || $user->application->status !== 'approved')) {
            $this->dispatch('redirectToApplicationForm');
            return;
        }

        $this->processReservation();
    }

    private function processReservation()
    {
        DB::transaction(function () {
            $userId = Auth::id();
            $foodListing = FoodListing::findOrFail($this->food_listing_id);
            $existingReservation = Reservation::where('food_listing_id', $this->food_listing_id)
                ->where('user_id', $userId)
                ->first();

            if ($existingReservation || $foodListing->quantity < 1) {
                $this->dispatch('reservationError', ['message' => 'This item cannot be reserved.']);
                return;
            }

            $reservation = new Reservation();
            $reservation->food_listing_id = $this->food_listing_id;
            $reservation->user_id = $userId;
            $reservation->status = 'Pending';
            $reservation->save();
            $foodListing->decrement('quantity');

            // Check if the reservation is approved here and send the notification
        if ($reservation->status === 'Approved') {
            $this->reservationNotifications($reservation);
        }
            $this->dispatch('modal-message', [
                'type' => 'success',
                'message' => 'Your reservation has been confirmed!'
            ]);
        });

        $this->toggleModal(false);
    }


}
