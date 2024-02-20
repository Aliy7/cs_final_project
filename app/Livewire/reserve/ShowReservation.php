<?php
namespace App\Livewire\reserve;


use Livewire\Component;
use App\Models\FoodListing;
use App\Models\Reservation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
            $reservation->status = $newStatus;
            $reservation->save();

            // Emitting an event to refresh the reservations list if needed
            $this->dispatch('statusUpdated');
        }

        // Refresh the list manually after an update
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
}