<?php

namespace App\Livewire\App;

use App\Models\FoodListing;
use Livewire\Component;
use Livewire\Attributes\On;
class AppLayout extends Component
{

    protected $listeners = ['showApplication' => '$showApplication'];

    #[on('showFoodListing')]
    public function updateFoodList($foodListing = null){
   
    }

    public function render()
    {
        return view('livewire.app.app-layout');
        
    }
}
