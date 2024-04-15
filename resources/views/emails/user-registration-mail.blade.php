@component('mail::message')
# Welcome, {{ $user->first_name }}

Thank you for registering with us. We're excited to have you on board!

@component('mail::button', ['url' => url('/dashboard')])
Visit Our Site
@endcomponent

Many Thanks,<br>
{{ config('app.name') }}
@endcomponent
