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

    //      // Fetch the food listing based on provided ID
    // $foodListing = FoodListing::find($this->foodListingId);
    // if (!$foodListing) {
    //     session()->flash('error', 'Invalid Food Listing.');
    //     return;
    // }
    //     // Calculate the available quantity if needed, or use a predefined quantity
    // $availableQuantity = $this->foodQuantity ?? $foodListing->available_quantity;

    // // Find users with the lowest income who are eligible to receive the email
    // $selectedUsers = $this->findUserWithLowestIncome($availableQuantity);
    
        $users = User::all();
      
        foreach($users as $user){
        $details = [
           
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

    public function findUserWithLowestIncome($quantity) {
        // Fetch users who are admins or have approved applications
        return User::select('users.*')
                   ->leftJoin('applications', 'applications.user_id', '=', 'users.id')
                   ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                   ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                   ->where('roles.name', '=', 'admin')
                   ->orWhere(function ($query) {
                       $query->where('applications.status', '=', 'approved');
                   })
                   ->orderBy('applications.family_income', 'asc')
                   ->orderByRaw('RAND()')
                   ->take($quantity)
                   ->get();
    }
    

}