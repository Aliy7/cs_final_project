<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FoodPostedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $details;
 

    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details =$details;
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
    // public function build()
    // {
    //     return $this
    //     ->from('food-sharing@app.com')
    //     ->to('customer@gmail.com')
    //     ->subject('Food has been listed')
    //     // ->attachFromStorage('images/images.png')
    //     ->markdown('emails.email-sender');
    // }

}
