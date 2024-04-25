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
use App\Mail\ApplicationEmails\ApplicationSubmitted;


/**
 * This class is responsible for application input form 
 * And Application related logic of handling multiple querries.
 */
class ApplicationComponent extends Component
{

    public $family_income;
    public $name;
    public $address_id;
    public $is_student;
    public $addresses = [];
    public $street;
    public $city;
    public $county;
    public $postcode;
    public $country;

    protected $listeners = [
        "addressUpdated" => '$addressUpdated',
        'inputValueUpdated' => 'updateInputValue'
    ];



    /**
     * Updates the input value based on the input ID.
     */
    public function updateInputValue($inputId, $value)
    {
        if ($inputId === 'city-input') {
            $this->city = $value;
        } elseif ($inputId === 'county-input') {
            $this->county = $value;
        } elseif ($inputId === 'country-input') {
            $this->country = $value;
        }
    }
    /**
     * Updates the address fields when an address is updated.
     */
    public function onAddressUpdate($address)
    {
        $this->street = $address['street'] ?? '';
        $this->city = $address['city'] ?? '';
        $this->county = $address['county'] ?? '';
        $this->postcode = $address['postcode'] ?? '';
        $this->country = $address['country'] ?? '';
    }
    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->first_name . ' ' . $user->last_name;
    }

    protected $rules = [
        'family_income' => 'required|numeric',
        'name' => 'required|string|max:25',
        'is_student' => 'required|boolean',
        'street' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'county' => 'required|string|max:255',
        'postcode' => 'required|string|max:255',
        'country' => 'required|string|max:255',
    ];


    /**
     * Handles the form submission:
     *  Validates the form input data.
     *  Checks if the user has already submitted an application.
     *  Ensures that only students can submit applications.
     *  Creates a new address record based on the input data.
     *  Creates a new application record with the user's input data.
     *  Automatically approves the application if the family income is less than or equal to 21000.
     *  Sends the application for admin approval if the family income is greater than 21000.
     *  Redirects the user to the appropriate dashboard page based on the outcome.
     */

    public function submit()
    {
        $this->validate();

        // Prevent multiple applications
        if (Application::where('user_id', auth()->id())->exists()) {
            session()->flash('error', 'You have already submitted an application.');
            return redirect()->to('/dashboard');
        }

        // Check if the applicant is a student
        if (!$this->is_student) {
            session()->flash('error', 'Currently, only students can submit applications.');
            return redirect()->to('/application-form');
        }

        $address = new Address();
        $address->street = $this->street;
        $address->city = $this->city;
        $address->county = $this->county;
        $address->postcode = $this->postcode;
        $address->country = $this->country;
        $address->user_id = Auth::id();

        $address->save();

        // Initialize the Application object
        $application = new Application();
        $application->user_id = Auth::id();
        $application->family_income = $this->family_income;
        $application->name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $application->address_id = $address->id;
        $application->is_student = $this->is_student;

        // Determine application status based on family income 
        if ($this->family_income <= 21000) {
            $application->status = 'approved';

            $application->save();

            session()->flash('message', 'Congratulations! Your application has been automatically approved. You can now proceed to make reservations.');
            return redirect()->to('/dashboard');
        } else if ($this->family_income > 21000) {
            $application->status = 'pending';

            $this->submittedNotification($application);
            $application->save();

            // session()->flash('message', 'Your application has been submitted and is currently pending approval. Please wait for further instructions.');
            // return redirect()->to('/dashboard');
        }
    }

    /**
     * Renders the component view.
     */
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

    /**
     * Triggers automatic notification once application is submitted.
     */

    public function submittedNotification($application)
    {
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

    /**
     * Stores automatic notification to be database once application is submitted.
     */
    protected function storeNotification($application, $subject, $body)
    {
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
