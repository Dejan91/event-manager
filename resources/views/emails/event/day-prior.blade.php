@component('mail::message')
# Greetings {{ $user->name }},

The event that you are interested in is going to start tomorrow.

Click <a href="http://localhost:8000/mails/{{ $user->id }}">here</a> to manage your email preferences.

Thanks,<br>
{{ config('app.name') }}
@endcomponent