<?php

namespace App\Livewire\Contact;

use App\Models\Contact;
use Livewire\Component;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * This class handles the functionality of the contact form.
 * It allows users to submit their name, email, and message, validates the input data, 
 * creates a new contact record in the database, and sends an email notification to the systems admin.
 */
class ContactForm extends Component
{

    public $name;
    public $email;
    public $message;

    // Validation rules for form fields
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|min:5',
    ];

    /**
     * Submit the contact form.
     * Validate input data, create a new contact record, send email notification,
     * and reset form fields after submission.
     */
    public function submitForm()
    {
        $this->validate();

        // Create a new contact record in the database

        $contact = Contact::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        // Send email notification to the support 

        Mail::to('support@example.com')->send(new ContactUsMail($contact));

        session()->flash('message', 'Contact form submitted successfully.');

        $this->reset(['name', 'email', 'message']);
    }

    /**
     * Render the contact form component view.
     * Layout the contact form within the app layout.
     */
    public function render()
    {
        return view('livewire.contact.contact-form')->layout('livewire.app.app-layout');
    }
}
