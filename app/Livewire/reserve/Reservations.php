<?php

namespace App\Livewire\reserve;
use App\Models\Reservation; 

use Livewire\Component;
use App\Models\FoodListing;
use Illuminate\Support\Facades\DB;

class Reservations extends Component
{

    public $food_listing_id;
    public $status;
    public $user_id;

    public function mount($food_listing_id)
    {
        $this->food_listing_id = $food_listing_id;
    }
    public function render()
    {
        $foodListings = FoodListing::all(); 

        return view('livewire.reservation.reservations');
      
    }

    
    public function reserve()
        {

        DB::transaction(function(){
            $foodListing = FoodListing::findOrFail($this->food_listing_id);

            $checkReservation = Reservation::where('food_listing_id', $this->food_listing_id)
            ->where('user_id', auth()->id())
            ->first();

            if($checkReservation){
                session()->flash('error', 'You have already made a reservation for this item');
                return;
            }
            if($foodListing->quantity < 1 ){
                session()->flash('error', 'This food item is no longer available.');
                return;

            }

        $reservation = new Reservation();
        $reservation->food_listing_id = $this->food_listing_id;
        $reservation->user_id = auth()->id();
        $reservation->status = 'Pending';
        $reservation->save();

        // Decrement the food quantity
        $foodListing->decrement('quantity');
        });
    }

    
}
