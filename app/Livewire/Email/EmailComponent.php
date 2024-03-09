<?php

namespace App\Livewire\Email;

use Log;
use App\Models\User;
use Livewire\Component;
use App\Models\FoodListing;
use Livewire\WithFileUploads; 
use App\Mail\EmailNotifications;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Mail;

class EmailComponent extends Component
{
    use WithFileUploads;

    public $mailNotification;
    public $attachments = [];

    public $foodQuantity;
    public $foodListingId;
    public $subject;
    public $email_body;
    public function render()
    {
        return view('livewire.email.email-component')
        ->layout('livewire.app.app-layout');
    }
    public function mount()
    {
        $this->mailNotification = collect(); 
        $this->fetchNotifications();
    }
    
    public function fetchNotifications()
    {
        $this->mailNotification = EmailNotification::where('user_id', auth()->id())
                                                   ->where('is_read', false)
                                                   ->latest()
                                                   ->get();
    }

    public function markNotificationAsRead($notificationId)
    {
        $mailNotification = EmailNotification::find($notificationId);

        if ($mailNotification && $mailNotification->user_id == auth()->id()) {
            $mailNotification->update(['is_read' => true]);
        }
    }

    protected $rules = [
        'foodQuantity' =>'nullable|numeric|min:1',
        'subject' => 'required|string|max:255',
        'email_body' => 'required|string',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }
    public function sendEmail() {
        // Validate input data.
        $this->validate();
    
        // Attempt to retrieve the FoodListing with the provided ID.
        $foodListing = FoodListing::find($this->foodListingId);
        if (!$foodListing) {
            session()->flash('error', 'Invalid Food Listing.');
            return;
        }
    
        // Calculate the available quantity.
        $availableQuantity = $foodListing->available_quantity;
    
        // Find users with the lowest income who are eligible to receive the email.
        $selectedUsers = $this->findUserWithLowestIncome($availableQuantity);
    
        // Iterate over the selected users and send them the email.
        foreach ($selectedUsers as $user) {
            // Create a new notification instance.
            $notification = new EmailNotification([
                'subject' => $this->subject,
                'email_body' => $this->email_body,
                'user_id' => $user->id,
                'food_listing_id' => $foodListing->id
            ]);
    
            $this->subject = "";
            $this->email_body = "";
            $this->foodQuantity = "";
            // Save the notification to associate it with the user and food listing.
            $notification->save();
    
            // Instantiate the mailable class.
            $email = new EmailNotifications($notification);
    
            // Check for attachments and add them to the email.
            if ($this->attachments) {
                foreach ($this->attachments as $attachment) {
                    $email->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                    ]);
                }
            }
    
            // Send the email to the user.
            try {
                        // Mail::to($whoPosted->email)->queue(new EmailNotification($notification));

                        Mail::to('hass@swansea.ac.uk')->send($email);
                        Mail::to($user->email)->queue($email);
                    } catch (\Exception $e) {
                // Log the exception and continue with the next iteration.
               \Log::error("Failed to send email to {$user->email}: {$e->getMessage()}");
            }
        }
    
        // Reset attachments after sending emails.
        $this->attachments = [];
    
        // Flash a session message for successful operation.
        session()->flash('message', 'Emails sent successfully.');
    }
    
    
   
    public function findUserWithLowestIncome($quantity) {
        // Fetch users who are admins or have approved applications
        return User::select('users.*')
                   ->leftJoin('applications', 'applications.user_id', '=', 'users.id')
                   ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id') // assuming you are using a package like spatie/laravel-permission
                   ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                   ->where('roles.name', '=', 'admin') // directly check for admin role
                   ->orWhere(function ($query) {
                       $query->where('applications.status', '=', 'approved');
                   })
                   ->orderBy('applications.family_income', 'asc')
                   ->orderByRaw('RAND()') // consider replacing RAND() with something more performant if your user base grows
                   ->take($quantity)
                   ->get();
    }
    
    public function updatedAttachments() {
        // Validate the attachments
        if ($this->attachments) {
            $this->validate([
                'attachments.*' => 'file|max:10240', 
            ]);
        }
    }

}    