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
                                                <img src="{{ $user->avatar_path }}" alt="user_avatar" id="userAvatar" width="140px" height="140px">
                                            </div>
                                        </div>
                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                            <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ $user->name }}</h4>
                                                <span class="badge badge-secondary">{{ $user->roles->first()->name }}</span>
                                                <div class="text-muted"><small>Joined {{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}</small></div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="{{ route('profile.show', [$user]) }}" class="{{ Route::is('profile.show') ? 'active' : '' }} nav-link">Profile</a></li>
                                        @can('update', $user)
                                            <li class="nav-item"><a href="{{ route('profile.edit', [$user]) }}" class="{{ Route::is('profile.edit') ? 'active' : '' }} nav-link">Settings</a></li>
                                            <li class="nav-item"><a href="{{ route('profile.mail.edit', [$user]) }}" class="{{ Route::is('profile.mail.edit') ? 'active' : '' }} nav-link">Mail preferences</a></li>
                                        @endcan
                                    </ul>
                                    <div class="tab-content pt-3">
                                        <div class="tab-pane active">

                                            @yield('profile')

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
                                    <button class="btn btn-block btn-secondary"
                                            onclick="event.preventDefault();
                                             document.getElementById('logout-button').submit();">
                                        <i class="fa fa-sign-out"></i>
                                        <span>Logout</span>
                                    </button>

                                    <form id="logout-button" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
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
