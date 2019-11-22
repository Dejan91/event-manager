@component('mail::message')
# Greetings {{ $user->name }},

The event that you are interested in is going to start tomorrow.

Click <a href="{{ route('profile.mail.edit', [$user]) }}">here</a> to manage your email preferences.

Thanks,<br>
{{ config('app.name') }}
@endcomponent