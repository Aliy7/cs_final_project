<?php

namespace App\Livewire\Privacy;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public function render()
    {
        return view('livewire.privacy.privacy-policy')
        ->layout('livewire.app.app-layout');
    }
}
