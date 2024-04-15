<?php
namespace App\Livewire\reserve;


use Livewire\Component;
use App\Models\FoodListing;
use App\Models\Reservation;
use Livewire\WithPagination;
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

            // Trigger notification if the new status is 'approved' and the previous status was not 'approved'
            if ($newStatus === 'approved' && $previousStatus !== 'approved') {
                $this->reservationNotifications($reservation);
            }

        // Refresh the list manually after an update
        $this->reservations = $this->queryReservations()->get();
    }
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