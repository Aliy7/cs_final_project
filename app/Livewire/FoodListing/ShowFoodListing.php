<?php

namespace App\Livewire\FoodListing;

use Livewire\Component;
use App\Models\FoodListing;
use Livewire\WithPagination;

class ShowFoodListing extends Component
{
    use WithPagination;

    public $foodListing;
    public function render()
    {
        // Directly fetch the listings in the render method
        return view('livewire.food-listing.show-food-listing', [
            'foodListings' => $this->getFoodListings(),
        ]);
    }

    public function getFoodListings()
    {
        return FoodListing::with('user')
                          ->orderBy('created_at', 'desc')
                          ->paginate(4);
    }
}
