<?php

namespace App\Livewire\Email;

use App\Models\User;
use Livewire\Component;
use App\Mail\FoodPostedNotification;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * This class manages the functionality to send emails and save email notifications.
 * It allows sending notifications to all users with customized content.
 */
class EmailSender extends Component
{

    public $email;
    public $subject;
    public $body;
    public $userId;
    public $foodListingId;
    /**
     * Render the view for the email sender component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.email.email-sender')
            ->layout('livewire.app.app-layout');
    }

    protected $rules = [
        'email' => 'required|email',
        'subject' => 'required|string',
        'body' => 'required|string',
        'userId' => 'required',
        'foodListingId' => 'required',
    ];

    /**
     * Send email notifications to all users.
     * This method validates the input fields, retrieves all users, iterates over each user,
     * sends an email notification with customized content, saves the notification details in the database,
     *
     * @return void
     */
    public function sendEmail()
    {
        // Validate input fields
        $this->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        // Retrieve all users
        $users = User::all();

        // Loop over each user to send notifications
        foreach ($users as $user) {
            $details = [

                'name' => $user->first_name ?? 'Valued User',

                'email' => $user->email,
                'subject' => $this->subject,
                'title' => 'Check out food has been listed',
                'body' => $this->body,
                'url' => '/dashboard',
                'footer' => 'Team Food Sharing App',
            ];

            // Send email notification
            Mail::send(new FoodPostedNotification($details));

            // Save notification details in the database
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

    /**
     * Find users with the lowest income.
     *
     * @param int $quantity The number of users to retrieve.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findUserWithLowestIncome($quantity)
    {
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
