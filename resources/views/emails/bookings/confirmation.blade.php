@component('mail::message')
# Hi {{ $booking->name }},

Your booking request has been confirmed for {{ $booking->requested_date->toDayDateTimeString() }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
