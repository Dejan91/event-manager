@component('mail::message')
# Greetings,

The event that you are interested to is going to start in 7 days.

Click <a href="http://localhost:8000/mail/preference">here</a> to manage your email preferences.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
