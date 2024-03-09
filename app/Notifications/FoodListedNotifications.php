<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Twilio\Rest\Client; // Import for Twilio Client

class FoodListedNotifications extends Notification 
{
    protected $account_sid;
    protected $auth_token;
    protected $twilio_number;
    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->account_sid = env('TWILIO_SID');
        $this->auth_token = env('TWILIO_TOKEN');
        $this->twilio_number = env('TWILIO_FROM');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return [ TwilioChannel::class];
    }
    

    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    public function toTwilio($notifiable)
    {
        $client = new Client($this->account_sid, $this->auth_token);
        $client->messages->create(
            $notifiable->phone_number, // Assuming you have the user's phone number
            [
                'from' => $this->twilio_number,
                'body' => "Here is my message to you. I love you above all." // Customize the message
            ]
        );
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
