<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    protected $listeners = ['food-listing-created' => '$refresh'];

    public function render()
    {
        return view('livewire.layout.dashboard')
        ->layout('layouts.app');
    }
}
