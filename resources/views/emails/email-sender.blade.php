{{-- @component('mail::message')

{{$details['title']}}
{{$details['body']}}
@component('mail::button', ['url' => $details['url']])
       More Details
@endcomponent
{{ $details['footer'] }}
Many Thanks, <br>
Team Food Sharing App
@endcomponent --}}
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

{{ $details['footer'] }}

Many Thanks,<br>
Team Food Sharing App
@endcomponent
