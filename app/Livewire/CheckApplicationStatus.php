<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CheckApplicationStatus extends Component
{
    public function mount()
    {
        $user = Auth::user();

        // Assuming 'application_status' is a property of the User model that indicates if the application is approved.
        if ($user->application_status !== 'approved') {
            return redirect('/application-form');
        }
    }

    public function render()
    {
        return view('livewire.test-redirect');
    }
}
