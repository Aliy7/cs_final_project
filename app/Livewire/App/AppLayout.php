<?php

namespace App\Livewire\App;

use App\Models\FoodListing;
use Livewire\Component;
use Livewire\Attributes\On;
class AppLayout extends Component
{

    // protected $listeners = ['setLocationCoordinates'];

    #[on('showFoodListing')]
    public function updateFoodList($foodListing = null){
    // dd('foodlistings');
    }

    // protected $listeners = [
    //     'foodListingCreated' => 'handleFoodListingCreated',
    //     'showFoodListing' => 'handleShowFoodListing',

    // ];
    
    // public function handleShowFoodListing(FoodListing $newFoodListing = null)
    // {
       
    //     if ($newFoodListing) {
    //         $this->foodListing->push($newFoodListing);
    //     }
    
    //     $this->dispatch('refresh')->self();
    // }
    
    // public function handleFoodListingCreated(FoodListing $foodListing)
    // {
    //     $this->foodListing->push($foodListing);
    //     $this->dispatch('refresh')->self();
    // }
    
    public function render()
    {
        return view('livewire.app.app-layout');
        
    }
}
