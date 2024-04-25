<?php

namespace App\Livewire\reserve;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovedReservationEmail;

/**
 * Livewire component to manage and display reservations.
 *
 * This component handles the display of reservation details, updating the status
 * of reservations, and sending notifications on approval of reservations. It includes
 * methods for querying reservations, updating reservation statuses, and handling the
 * collection of reserved items.
 */
class ShowReservation extends Component
{
    /**
     * List of reservations to display.
     *
     * @var mixed
     */
    public $reservations;


    /**
     * Mount the component and fetch reservations for the current user or all users if admin.
     */
    public function mount()
    {
        $this->reservations = $this->queryReservations()->get();
    }

    /**
     * Update the status of a reservation.
     *
     * Allows administrators to update the status of a reservation. Notifies the user
     * if the reservation status is updated to 'approved'.
     *
     * @param int $reservationId ID of the reservation.
     * @param string $newStatus New status to set ('approved', 'pending', etc.).
     */
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

    /**
     * Mark a reservation as collected.
     *
     * Only accessible by administrators, this function updates the collection status
     * of a reservation.
     *
     * @param int $reservationId ID of the reservation to mark.
     * @param string $value Collection status ('1' for collected, '0' for not collected).
     */
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

        $this->reservations = $this->queryReservations()->get();
    }

    /**
     * Query reservations based on user role.
     *
     * Admins see all reservations, while other users see only their reservations.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function queryReservations()
    {
        return Reservation::with(['user', 'foodListing'])
            ->when(!Auth::user()->hasRole('admin'), function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest();
    }

    /**
     * Render the Livewire component view.
     *
     * @return \Illuminate\View\View Livewire view with reservations data.
     */
    public function render()
    {
        return view('livewire.reservation.show-reservation', [
            'reservations' => $this->reservations,
        ])->layout('livewire.app.app-layout');
    }

    /**
     * Send email notification upon reservation approval.
     *
     * This method sends an email to the user whose reservation was approved and
     * logs the notification in the database.
     *
     * @param Reservation $reservation The reservation instance.
     */
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
        Mail::to($user->email)->send(new ApprovedReservationEmail($details));
        $notification = new EmailNotification;
        $notification->user_id = $user->id;
        $notification->is_read = false;
        $notification->subject = $details['subject'];
        $notification->email_body = $details['body'];
        $notification->save();
    }
}
