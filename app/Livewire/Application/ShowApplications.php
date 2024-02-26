<?php

namespace App\Livewire\Application;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShowApplications extends Component
{
    use WithPagination;


    public $applications; // Define the applications property

    public function mount()
    {
        $this->applications = $this->queryApplications()->get();
    }

    public function render()
    {
        return view('livewire.application.show-applications', [
            'applications' => $this->applications, // Pass the applications property
        ])->layout('livewire.app.app-layout');
    }

   
    protected function queryApplications()
    {
        // If the user is an admin, they can see all applications; otherwise, they can only see their own
        return Application::with(['user'])
            ->when(!Auth::user()->hasRole('admin'), function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest();
    }

    public function updateStatus($applicationId, $newStatus)
    {
        // Only allow users with the 'admin' role to update the status
        if (Auth::user()->hasRole('admin')) {
            $application = Application::findOrFail($applicationId);
            $application->status = $newStatus;
            $application->save();

            // Emitting an event to refresh the applications list if needed
            $this->dispatch('statusUpdated');
        } else {
            // Optional: Add an error message or some form of notification that the user is unauthorized
        }

        // Refresh the list manually after an update
        $this->applications = $this->queryApplications()->get();
    }
}