<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;

class ShowProfile extends Component
{

    public $profileId;
    public $profile;
    public function render()
    {
        return view('livewire.profile.show-profile', [
            'profile' => $this->profile,
        ])->layout('livewire.app.app-layout');
    }
    
    public function mount($profileId)
    {
        $this->profileId = $profileId; 
        $this->profile = Profile::where('user_id', $profileId)->first();
        
    
    }
    
    
}
