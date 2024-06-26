<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;

/**
 * The ShowProfile class displays the details of a user's profile.
 * It retrieves and renders the profile information for a specific user.
 */
class ShowProfile extends Component
{

    public $profileId;
    public $profile;

    /**
     * Render the component view.
     * It renders the view for displaying the user's profile details.
     *
     * @return \Illuminate\View\View The view for displaying user profile.
     */
    public function render()
    {
        return view('livewire.profile.show-profile', [
            'profile' => $this->profile,
        ])->layout('livewire.app.app-layout');
    }

    /**
     * Initialize the component with the specified profile ID.
     * It retrieves the profile information based on the provided profile ID.
     *
     * @param int $profileId The ID of the profile to be displayed.
     * @return void
     */
    public function mount($profileId)
    {
        $this->profileId = $profileId;
        $this->profile = Profile::where('user_id', $profileId)->first();
    }
}
