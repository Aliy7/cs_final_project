@component('mail::message')
# {{ $details['title'] }}

Dear {{ $details['name'] }},

{{ $details['body'] }}

@component('mail::button', ['url' => $details['url']])
View Application
@endcomponent

{{ $details['footer'] }}

@endcomponent
