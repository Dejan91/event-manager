@component('mail::message')
# Greetings {{ $user->name }},

The event that you are interested to is going to start in 7 days.

Click <a href="{{ route('profile.mail.edit', [$user]) }}">here</a> to manage your email preferences.

<p>Or</p>

<a href="{{ route('profile.mail.delete', [$user, $unsubscribeToken]) }}">Unsubscribe from all mails.</a>
{{--<a href="{{ url("http://event-manager.test/users/{$user->id}/mails/delete/{$unsubscribeToken->token}") }}">Unsubscribe from all mails.</a>--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
