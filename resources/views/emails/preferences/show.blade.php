@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Email Preferences</h1>

        <form action="/mails" method="POST">
            @csrf
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="weekly_event_mail" name="weekly_event_mail" {{ $user->wantsWeeklyMail() ? 'checked' : '' }}>
                <label class="custom-control-label" for="weekly_event_mail">Weekly Event Mails</label>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="daily_event_mail" name="daily_event_mail" {{ $user->wantsDailyMail() ? 'checked' : '' }}>
                <label class="custom-control-label" for="daily_event_mail">Daily Event Mails</label>
            </div>

            <button type="submit" class="btn btn-success mt-3">Apply Changes</button>
        </form>
    </div>
@endsection