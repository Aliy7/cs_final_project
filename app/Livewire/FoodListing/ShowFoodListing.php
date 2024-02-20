<?php

namespace App\Livewire\FoodListing;

use App\Livewire\App\AppLayout;
use App\Livewire\Dashboard;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\FoodListing;
use Livewire\WithPagination;

class ShowFoodListing extends Component
{
    use WithPagination;

    public $foodListing;

    protected $listeners = [
        'foodListingCreated' => 'handleFoodListingCreated',
       
    ];

    #[on('foodListingCreated')]
    public function handleFoodListingCreated()
    {
        // Optionally refresh $foodListings if needed
        $this->foodListing = $this->getFoodListings();
    }

    // #[on('reserved')]
    // public function reserved($foodListing_id){

    // }

    // #[On('locationSaved')]
    // public function updateLocation(){

    // }
    public function render()
    {
        return view('livewire.food-listing.show-food-listing', [
            'foodListings' => $this->getFoodListings(),
        ]) ->layout('livewire.app.app-layout');
        ;
    }

    public function getFoodListings()
    {
        return $foodlistings = FoodListing::with('user', 'location')
                          ->orderBy('created_at', 'desc')
                          ->paginate(4);
                          
    }


}
