<?php

namespace App\Livewire\Application;

use Livewire\Component;
use App\Models\Application;
use Illuminate\Validation\Rule;

class ApplicationComponent extends Component
{

    public $family_income;
    public $name;
    public $address_id;
    public $is_student;
    public $addresses = []; 
    public $street, $city, $state, $postalCode, $country;

    // protected $rules = [
    //     'family_income' => 'required|numeric',
    //     'name' => 'required|string|max:255',
    //     'address_id' => 'required|exists:addresses,id',
    //     'is_student' => 'required|boolean',
    // ];
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
    
// public function submit()
// {
//     $this->validate();

//     // Check if the user has already submitted an application
//     if (Application::where('user_id', auth()->id())->exists()) {
//         session()->flash('error', 'You have already submitted an application.');
//         return redirect()->to('/dashboard'); // Adjust the redirection as needed
//     }

//     // Ensure the user is a student
//     if (!$this->is_student) {
//         session()->flash('error', 'Only students can submit applications at this time.');
//         return redirect()->to('/application-form'); // Adjust as necessary
//     }

//     // Determine the application status based on family income
//     $status = $this->family_income <= 21000 ? 'approved' : 'pending';

//     // Create the application instance
//     $application = new Application([
//         'user_id' => auth()->id(),
//         'family_income' => $this->family_income,
//         'name' => $this->name,
//         'address_id' => $this->address_id,
//         'is_student' => $this->is_student,
//         'status' => $status,
//     ]);

//     // Save the application
//     $application->save();

//     $message = $status === 'approved' ? 'Your application has been automatically approved.' : 'Your application has been submitted successfully and is pending approval.';
//     session()->flash('message', $message);

//     return redirect()->to('/dashboard'); // Or wherever you want to redirect after submission.
// }
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

    // Create an Address record first
    $address = \App\Models\Address::create([
        'street' => $this->street,
        'city' => $this->city,
        'state' => $this->state,
        'postalCode' => $this->postalCode,
        'country' => $this->country,
    ]);

    // Determine application status based on family income and proceed accordingly
    if ($this->family_income <= 21000) {
        $status = 'approved';
        // Use the newly created address's ID for the application
        $application = Application::create([
            'user_id' => auth()->id(),
            'family_income' => $this->family_income,
            'name' => $this->name,
            'address_id' => $address->id,
            'is_student' => $this->is_student,
            'status' => $status,
        ]);

        session()->flash('message', 'Congratulations! Your application has been automatically approved. You can now proceed to make reservations.');
        return redirect()->to('/dashboard');
    } else if ($this->family_income > 21000) {
        $status = 'pending';
        // Use the newly created address's ID for the application
        $application = Application::create([
            'user_id' => auth()->id(),
            'family_income' => $this->family_income,
            'name' => $this->name,
            'address_id' => $address->id,
            'is_student' => $this->is_student,
            'status' => $status,
        ]);

        session()->flash('message', 'Your application has been submitted and is currently pending approval. Please wait for further instructions.');
        return redirect()->to('/application-status');
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
}
