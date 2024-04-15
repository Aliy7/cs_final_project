<?php

namespace App\Livewire\reserve;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovedReservationEmail;

class ShowReservation extends Component
{
    public $reservations;

    public function mount()
    {
        $this->reservations = $this->queryReservations()->get();
    }

    public function updateStatus($reservationId, $newStatus)
    {
        if (Auth::user()->hasRole('admin')) {
            $reservation = Reservation::findOrFail($reservationId);
            $previousStatus = $reservation->status;
            $reservation->status = $newStatus;
            $reservation->save();

            if ($newStatus === 'approved' && $previousStatus !== 'approved') {
                $this->reservationNotifications($reservation);
            }

            $this->reservations = $this->queryReservations()->get();
        }
    }
    public function markAsCollected($reservationId, $value)
    {
        if (!Auth::user()->hasRole('admin')) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $reservation = Reservation::findOrFail($reservationId);
        $reservation->hasCollected = $value === '1'; // '1' for Yes, '0' for No
        $reservation->save();

        session()->flash('success', 'Collection status updated to ' . ($value === '1' ? 'Yes' : 'No') . '.');

        // Refresh the list of reservations
        $this->reservations = $this->queryReservations()->get();
    }

    protected function queryReservations()
    {
        return Reservation::with(['user', 'foodListing'])
            ->when(!Auth::user()->hasRole('admin'), function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest();
    }

    public function render()
    {
        return view('livewire.reservation.show-reservation', [
            'reservations' => $this->reservations,
        ])->layout('livewire.app.app-layout');
    }


    public function reservationNotifications($reservation)
    {

        $user = $reservation->user;
        $details = [
            'email' => $user->email,
            'name' => $user->first_name ?? $user->username,
            'subject' => 'Reservation Approved',
            'title' => 'Your Reservation Has Been Approved',
            'body' => 'Please you are advised to come and collect your reservation',
            'url' => url('/dashboard'),
            'footer' => 'Thanks for using our app!'
        ];
        Mail::to($user->email)->queue(new ApprovedReservationEmail($details));


        $notification = new EmailNotification;
        $notification->user_id = $user->id;
        $notification->is_read = false;
        $notification->subject = $details['subject'];
        $notification->email_body = $details['body'];
        $notification->save();
    }
}
