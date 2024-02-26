<?php

namespace App\Livewire\reserve;

use App\Livewire\Application\ApplicationComponent;
use Livewire\Component;

use App\Models\FoodListing;
use App\Models\Reservation; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Reservations extends Component
{
    public $food_listing_id;

    public $showModal = false;
   
    public $isApplicationApproved = false;


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

    // Set to true if the user is an admin or their application is approved
    $this->isApplicationApproved = $user->hasRole('admin') || ($userApplication && $userApplication->status === 'approved');


    }

    // In your Livewire component's PHP method that closes the modal:
public function closeModal()
{
    $this->showModal = false;
    $this->dispatch('modal-closed');
}

    public function render()
    {
        $foodListings = FoodListing::all(); 

        return view('livewire.reservation.reservations', [
            'foodListings' => $foodListings,
            'showmessage' => $this->isApplicationApproved,
        ]);
    }
    
    public function reserve()
    {
        $user = Auth::user();

        if (!$this->isApplicationApproved) {
            // Notify the user that they need to have an approved application to reserve
            $this->dispatchBrowserEvent('modal-message', [
                'type' => 'error',
                'message' => 'Please ensure your application is approved before making a reservation.'
            ]);
            return;
        }
        if (!Auth::user()->hasRole('admin')) {
            $userApplication = $user->application ?? null;
            if (!$userApplication || $userApplication->status !== 'approved') {
                $this->dispatchBrowserEvent('redirectToApplicationForm');
                return;
            }
        }
    

        DB::transaction(function() {
            $userId = Auth::id();
            $foodListing = FoodListing::findOrFail($this->food_listing_id);
            $existingReservation = Reservation::where('food_listing_id', $this->food_listing_id)
                                               ->where('user_id', $userId)
                                               ->first();

            if ($existingReservation || $foodListing->quantity < 1) {
                // Optionally, notify the user if the reservation cannot be made
                $this->dispatch('reservationError', ['message' => 'This item cannot be reserved.']);
                return;
            }

            $reservation = new Reservation();
        $reservation->food_listing_id = $this->food_listing_id;
        $reservation->user_id = auth()->id();
        $reservation->status = 'Pending';
        $reservation->save();
            $foodListing->decrement('quantity');
            // Notify of successful reservation
            // $this->dispatch('reservationMade');

            // $this->toggleModal(false);
            $this->dispatch('modal-message', [
                'type' => 'success',
                'message' => 'Your reservation has been confirmed!'
            ]);
        });

        $this->toggleModal(false); //

    
    }
}