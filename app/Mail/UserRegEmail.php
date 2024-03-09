<?php

namespace App\Mail;

use App\Models\EmailNotification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Reg Email',
        );
    }

    public function build()
    {
        $mail = $this->from('share-me@app.com', 'YourAppName')
                     ->to($this->user->email)
                     ->subject('Welcome to YourAppName!')
                     ->markdown('emails.user-registration-mail', ['user' => $this->user]);
    
        // Log the email details to the database
        $notification = new EmailNotification;
        $notification->user_id = $this->user->id;
        $notification->subject = 'Welcome to YourAppName!';
        $notification->email_body = 'Thank you for registering with us. We\'re excited to have you on board!';
        $notification->is_read = false; // Assuming it's unread when initially created
        // Set other fields as necessary
        $notification->save();

        return $mail;
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
