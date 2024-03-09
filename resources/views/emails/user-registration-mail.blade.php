@component('mail::message')
# Welcome, {{ $user->first_name }}

Thank you for registering with us. We're excited to have you on board!

@component('mail::button', ['url' => 'https://final_projects.test/dashboard'])
Visit Our Site
@endcomponent

Many Thanks,<br>
{{ config('app.name') }}
@endcomponent
