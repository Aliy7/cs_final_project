<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;

class ShowProfile extends Component
{

    public $profile;
    public function render()
    {
        return view('livewire.profile.show-profile', [
            'profile' => $this->profile,
        ])->layout('livewire.app.app-layout');
    }

    public function mount($profileId)
    {
        $this->profile = Profile::with('user')->find($profileId);
    
        if (!$this->profile) {
            abort(404, 'This is Profile not found');
        }
    }
    
}
