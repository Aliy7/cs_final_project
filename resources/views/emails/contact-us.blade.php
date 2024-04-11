@component('mail::message')
# Contact Us Request

You have a new contact request.

**Name:** {{ $contact->name }}

**Email:** {{ $contact->email }}

**Message:**

{{ $contact->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
