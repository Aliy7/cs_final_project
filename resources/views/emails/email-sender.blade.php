@component('mail::message')

# Dear {{ $details['name'] }},
<br>
{{ $details['title'] }}
<br>
<hr>
{{ $details['body'] }}

@component('mail::button', ['url' => $details['url']])
More Details
@endcomponent


Many Thanks,<br>
{{ $details['footer'] }}

@endcomponent
