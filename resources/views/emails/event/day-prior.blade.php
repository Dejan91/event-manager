@component('mail::message')
# Greetings {{ $user->name }},

The event that you are interested in is going to start tomorrow.

{{-- <a href="{{ route('profile.mail.delete', [$user]) }}">Unsubscribe from all mails.</a> --}}
<a href="{{ url("http://event-manager.test/users/{$user->id}/mails/delete") }}">Unsubscribe from all mails.</a>

<p>Or</p>

Click <a href="{{ route('profile.mail.edit', [$user]) }}">here</a> to manage your email preferences.

Thanks,<br>
{{ config('app.name') }}
@endcomponent