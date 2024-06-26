<?php

namespace App\Livewire;
use Livewire\Component;

class Dashboard extends Component
{
    protected $listerners = [
        'FAQEdited' => '$FAQEdited'
    ];

    public function render()
    {
        return view('livewire.layout.dashboard')
        ->layout('livewire.app.app-layout');
    }
}
