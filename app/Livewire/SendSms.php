<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SendSms extends Component
{
    public function mount()
    {
        $this->sendSmsMessage();
    }

    public function sendSmsMessage()
    {
        $sid = config('services.twilio.sid'); // Ensure these are set in your config/services.php
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        $to = '+1234567890'; // The number you want to send an SMS to
        $body = 'Your SMS message text';

        $response = Http::asForm()->withBasicAuth($sid, $token)->post("https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json", [
            'From' => $from,
            'To' => $to,
            'Body' => $body,
        ]);

        if ($response->successful()) {
            session()->flash('message', 'SMS sent successfully!');
        } else {
            session()->flash('error', 'Failed to send SMS.');
        }
    }
    public function render()
    {
        return view('livewire.send-sms');
    }
}
