<?php

namespace App\Livewire\FoodListing;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ShowFoodListing extends Component
{

    use WithFileUploads;
    // public $tag;
    public function render()
    {
        return view('livewire.food-listing.show-food-listing');
    }
}
