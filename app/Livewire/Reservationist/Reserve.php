<?php

namespace App\Livewire\Reservationist;

use Livewire\Component;

class Reserve extends Component
{
    public function render()
    {
        // dd("balde is here");
        return view('livewire.reservationist.reserve') ->layout('layouts.app');
    }
}
