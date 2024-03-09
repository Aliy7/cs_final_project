@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<a href="{{route('dashboard') }}" class="flex ms-2 md:me-24">
    {{-- <img src="/storage/logo/mylogo.png" class="h-8 me-3" alt="logo" /> --}}
    <span class="logo-text">Shareme</span>
   </a>@else
{{ $slot }}
@endif
</a>
</td>
</tr>
