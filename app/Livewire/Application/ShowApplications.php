<?php

namespace App\Livewire\Application;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationEmails\ApprovedAppEmail;

/**
 * This class is responsible for displaying and managing applications.
 * It provides functionality for displaying applications, updating their status, 
 * and sending notifications upon status change.
 */
class ShowApplications extends Component
{
    use WithPagination;

    public $applications;

    public function mount()
    {
        $this->applications = $this->queryApplications()->get();
    }

    public function render()
    {
        // Render the component view with applications data

        return view('livewire.application.show-applications', [
            'applications' => $this->applications,
        ])->layout('livewire.app.app-layout');
    }

    /**
     * Query applications based on user role.
     * Admin users can see all applications, while non-admin users can only see their own.
     */
    protected function queryApplications()
    {
        return Application::with(['user'])
            ->when(!Auth::user()->hasRole('admin'), function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest();
    }

    /**
     * Update application status.
     * Only admins can update status. If status is 'approved', 
     * send approval notification.
     */
    public function updateStatus($applicationId, $newStatus)
    {
        // Only allow users with the 'admin' role to update the status
        if (Auth::user()->hasRole('admin')) {
            $application = Application::with('user')->findOrFail($applicationId);
            $application->status = $newStatus;
            $application->save();

            // If the new status is 'approved', send an approval notification
            if ($newStatus == 'approved') {
                $this->approvedNotification($application);
            }

            $this->dispatch('statusUpdated');
        } else {
            Log::warning('Non-admin user attempted to update status.');
        }
        $this->applications = $this->queryApplications()->get();
    }

    /**
     * Send notification to user upon application approval.
     */
    protected function approvedNotification($application)
    {
        $user = $application->user;
        $details = [
            'email' => $user->email,
            'name' => $user->first_name ?? 'User',
            'subject' => 'Application Approved',
            'title' => 'Your Application Has Been Approved',
            'body' => 'Congratulations, your application has been approved.',
            'url' => url('/dashboard'),
            'footer' => 'Thanks,'
        ];

        // Send approval email
        Mail::to($user->email)->send(new ApprovedAppEmail($details));
        //Save notification in database
        $notification = new EmailNotification();
        $notification->user_id = $user->id;
        $notification->is_read = false;
        $notification->subject = $details['subject'];
        $notification->email_body = $details['body'];
        $notification->save();
    }
}
