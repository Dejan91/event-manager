@component('mail::message')
# Greetings {{ $user->name }},

The event that you are interested to is going to start in 7 days.

Click <a href="{{ route('profile.mail.edit', [$user]) }}">here</a> to manage your email preferences.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
