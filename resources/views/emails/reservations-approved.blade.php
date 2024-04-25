@component('mail::message')
# {{ $details['title'] }}

Dear {{ $details['name'] }},

{{ $details['body'] }}

@component('mail::button', ['url' => $details['url']])
Ready for pick up
@endcomponent

{{ $details['footer'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
