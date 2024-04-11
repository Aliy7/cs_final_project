<?php

namespace App\Mail\ApplicationEmails;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $details;
    public $application;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build() {
        return $this
            ->from('share-me@app.com')
            ->to($this->details['email'])
            ->subject($this->details['subject'])
            ->markdown('emails.app-approved', ['details' => $this->details]); // Adjust the view as needed
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Submitted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.app.submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
