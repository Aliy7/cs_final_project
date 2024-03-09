<?php

namespace App\Mail;

use App\Models\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotifications extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public EmailNotification $mailNotification;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailNotification $mailNotification)
    {
        $this->mailNotification = $mailNotification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '$this->mailNotification->title',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email-email-component',
            with:['mailNotification' =>$this->mailNotification]
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

    /**
     * Build the notification email.
     */
    public function build()
    {
        $email = $this->from('hello@example.com', config('app.name'))
                      ->subject($this->mailNotification->title)
                      ->view('livewire.email.email-component', ['mailNotification' => $this->mailNotification]);

        if (isset($this->mailNotification->attachments)) {
            foreach ($this->mailNotification->attachments as $attachment) {
                $email->attach($attachment->getRealPath(), [
                    'as' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getClientMimeType(),
                ]);
            }
        }

        return $email;
    }


   

}
