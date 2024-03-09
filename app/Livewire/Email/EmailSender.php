<?php

namespace App\Livewire\Email;

use App\Models\User;
use Livewire\Component;
use App\Mail\FoodPosted;
use App\Mail\FoodPostedNotification;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailSender extends Component
{
    public function render()
    {
        return view('livewire.email.email-sender')
        ->layout('livewire.app.app-layout');
    }

    public $email, $subject, $body, $userId, $foodListingId;

    protected $rules = [
        'email' => 'required|email',
        'subject' => 'required|string',
        'body' => 'required|string',
        'userId' => 'required',
        'foodListingId' => 'required',
    ];

    public function sendEmail()
    {
        $this->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);
    
        $userId = auth()->id();

        // Alternatively, if $this->userId is set to the target user's ID
        // $userId = $this->userId;
    
        $users = User::all();
      
        foreach($users as $user){
        $details = [
            // 'subject' => $this->subject,
            // 'body' => $this->body,
            'name' => $user->first_name ?? 'Valued User', 

            'email' => $user->email,            
            'subject' => $this->subject,
            'title' => 'Check out food has been listed',  // Example title
            'body' => $this->body,  // The body content from the form
            'url' => 'https://final_projects.test/dashboard',  // Example URL
            'footer' => 'Team Food Sharing App',
        ];
    
        Mail::send(new FoodPostedNotification($details));

        
        $notification = new EmailNotification();

        $notification->user_id = Auth::id();
        $notification->food_listing_id = $this->foodListingId;
        $notification->is_read = false;

        $notification->subject = $this->subject;
        $notification->email_body = $this->body;
        $notification->save();
    }
        session()->flash('message', 'Email sent and notification saved successfully!');
        $this->reset(['email', 'subject', 'body', 'userId', 'foodListingId']);
    }

}