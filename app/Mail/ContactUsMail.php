<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Us Request from ' . $this->contact->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-us'
        );
    }

    public function attachments(): array
    {
        // Assuming your Contact model might have attachments
        // You would adjust this based on your actual attachment setup
        $attachments = [];
        if ($this->contact->attachments) {
            foreach ($this->contact->attachments as $attachment) {
                $attachments[] = [
                    'file' => $attachment->getRealPath(),
                    'options' => [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                    ]
                ];
            }
        }
        return $attachments;
    }

   
        public function build()
        {
            return $this
                ->from('share-me@app.com')
                ->subject('New Contact Us Request from ' . $this->contact->name)
                ->markdown('emails.contact-us', ['contact' => $this->contact]);
        }
      
}