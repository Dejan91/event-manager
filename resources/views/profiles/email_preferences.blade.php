@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row flex-lg-nowrap">
        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                                <div class="row">
                                    <div class="col-12 col-sm-auto mb-3">
                                        <div class="mx-auto" style="width: 140px;">
                                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ $user->name }}</h4>
                                            <p class="mb-0">@johnny.s</p>
                                            <div class="text-muted"><small>Last seen 2 hours ago</small></div>
                                        </div>
                                        <div class="text-center text-sm-right">
                                            <span class="badge badge-secondary">administrator</span>
                                            <div class="text-muted"><small>Joined 09 Dec 2017</small></div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="{{ route('profile.edit', [$user]) }}" class="nav-link">Settings</a></li>
                                    <li class="nav-item"><a href="{{ route('profile.mail.edit', [$user]) }}" class="active nav-link">Mail preferences</a></li>
                                </ul>
                                <div class="tab-content pt-3">
                                    <div class="tab-pane active">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="px-xl-3">
                                <button class="btn btn-block btn-secondary">
                                    <i class="fa fa-sign-out"></i>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title font-weight-bold">Support</h6>
                            <p class="card-text">Get fast, free help from our friendly assistants.</p>
                            <button type="button" class="btn btn-primary">Contact Us</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection