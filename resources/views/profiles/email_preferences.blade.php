@extends('profiles.profile')

@section('profile')
    <form class="form" method="POST" action="{{ route('profile.mail.update', [$user]) }}">
        @csrf
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <label>Email Notifications</label>
                        <div class="custom-controls-stacked px-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="daily_event_mail" name="daily_event_mail" {{ $user->wantsDailyMail() ? 'checked' : '' }}>
                                <label class="custom-control-label" for="daily_event_mail">Daily Events Mails</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="weekly_event_mail" name="weekly_event_mail" {{ $user->wantsWeeklyMail() ? 'checked' : '' }}>
                                <label class="custom-control-label" for="weekly_event_mail">Weekly Events Mails</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


