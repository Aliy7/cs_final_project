<?php

namespace App\Livewire\Contact;

use App\Models\Contact;
use Livewire\Component;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{

    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|min:5',
    ];

    public function submitForm()
    {
        $this->validate();

        $contact = Contact::create([
            'user_id' => Auth::id(), 
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        Mail::to('support@example.com')->send(new ContactUsMail($contact));
        
        session()->flash('message', 'Contact form submitted successfully.');

        $this->reset(['name', 'email', 'message']);
    }
    public function render()
    {
        return view('livewire.contact.contact-form')->layout('livewire.app.app-layout');
    }
}
