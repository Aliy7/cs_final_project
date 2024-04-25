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

/**
 * The UserRegEmail class represents an email sent to new users upon registration.
 * It extends the Mailable class and implements ShouldQueue interface for queuing.
 */
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
    
        $notification = new EmailNotification;
        $notification->user_id = $this->user->id;
        $notification->subject = 'Welcome to YourAppName!';
        $notification->email_body = 'Thank you for registering with us. We\'re excited to have you on board!';
        $notification->is_read = false; 
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
