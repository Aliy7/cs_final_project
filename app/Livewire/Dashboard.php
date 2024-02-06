<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    // protected $listeners = ['foodListingCreated' => '$refresh'];

    public function render()
    {
        return view('livewire.layout.dashboard')
        ->layout('layouts.app');
    }
}
