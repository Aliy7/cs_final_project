<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * The FoodPostedNotification class represents an email notification for posted food listings.
 * It extends the Mailable class and implements ShouldQueue interface for queuing.
 */
class FoodPostedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $details;


    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Food Posted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-sender',
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
    public function build()
    {
        return $this
            ->from('share-me@app.com')
            ->to($this->details['email'])
            ->subject($this->details['subject'])
            ->markdown('emails.email-sender', ['details' => $this->details]);
    }
}
