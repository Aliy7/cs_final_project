<?php

namespace App\Livewire\Application;

use App\Models\User;
use App\Models\Address;
use Livewire\Component;
use App\Models\Application;
use Illuminate\Validation\Rule;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationEmails\ApprovedAppEmail;
use App\Mail\ApplicationEmails\ApplicationSubmitted;

class ApplicationComponent extends Component
{

    public $family_income;
    public $name;
    public $address_id;
    public $is_student;
    public $addresses = []; 
    public $street, $city, $state, $postalCode, $country;


    protected $rules = [
        'family_income' => 'required|numeric',
        'name' => 'required|string|max:255',
        'is_student' => 'required|boolean',
        'street' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'postalCode' => 'required|string|max:255',
        'country' => 'required|string|max:255',
    ];
    

public function submit()
{
    $this->validate();

    // Prevent duplicate applications
    if (Application::where('user_id', auth()->id())->exists()) {
        session()->flash('error', 'You have already submitted an application.');
        return redirect()->to('/dashboard');
    }

    // Check if the applicant is a student
    if (!$this->is_student) {
        session()->flash('error', 'Currently, only students can submit applications.');
        return redirect()->to('/application-form');
    }

    // Create an Address record first using a more verbose but consistent approach
    $address = new Address();
    $address->street_name = $this->street;
    $address->city = $this->city;
    $address->state = $this->state;
    $address->postcode = $this->postalCode;
    $address->country = $this->country;
    $address->user_id = Auth::id();

    $address->save();

    // Initialize the Application object
    $application = new Application();
    $application->user_id = Auth::id();
    $application->family_income = $this->family_income;
    $application->name = $this->name;
    $application->address_id = $address->id;
    $application->is_student = $this->is_student;

    // Determine application status based on family income and set messages accordingly
    if ($this->family_income <= 21000) {
        $application->status = 'approved';

        $application->save();

        session()->flash('message', 'Congratulations! Your application has been automatically approved. You can now proceed to make reservations.');
        return redirect()->to('/dashboard');
    } else if ($this->family_income > 21000) {
        $application->status = 'pending';

        $this->submittedNotification($application);
        $application->save();

        session()->flash('message', 'Your application has been submitted and is currently pending approval. Please wait for further instructions.');
        return redirect()->to('/dashboard');
    }
}


    public function render()
    {
        return view('livewire.application.application-component')
            ->layout('livewire.app.app-layout');
    }

    public function updated($propertyName)
{
    $this->validateOnly($propertyName, [
        'address_id' => [
            'required',
            Rule::exists('addresses', 'id')->where(function ($query) {
                $query->where('user_id', auth()->id());
            }),
        ],
    ]);
}


public function submittedNotification($application) {
    $user = $application->user;
    $details = [
        'email' => $user->email,
        'name' => $user->first_name ?? 'User',
        'subject' => 'We have received you application now',
        'title' => 'Your Application Has Been Submitted',
        'body' => 'Your application is now under review.',
        'url' => url('/dashboard'),
        'footer' => 'Thanks, Team Food Sharing'
    ];

    Mail::to($user->email)->send(new ApplicationSubmitted($details));
   
    $this->storeNotification($application, $details['subject'], $details['body']);
}

protected function storeNotification($application, $subject, $body) {
    $userId = Auth::id();

    if (!$userId) {
        return;
    }

    $notification = new EmailNotification();
    $notification->user_id = $userId;
    $notification->is_read = false;
    $notification->subject = $subject;
    $notification->email_body = $body;
    $notification->save();
}



}


// }

