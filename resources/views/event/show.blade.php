@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/jquery.atwho.css') }}">
@endsection

@section('content')
<event-view :event="{{ $event }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{ $event->image_path }}" class="card-img-top" alt="Event Image" width="500" height="400">
                    <div class="card-body">
                        <h2 class="card-title">{{ $event->title }} at {{ $event->country->name }}</h2>
                        <p class="card-text">{{ $event->description }}</p>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <span class="font-weight-bold">Start: </span>{{ $event->start_date->format('Y-m-d') }}
                            </div>
                            <div class="col-md-6">
                                <span class="font-weight-bold">End: </span>{{ $event->end_date->format('Y-m-d') }}
                            </div>
                        </div>
                        <div class="float-left mt-2">
                            <subscribe-button :data="{{ $event }}"></subscribe-button>
                        </div>
                        <div class="float-right mt-2 mr-2">
                            <favorite :model="{{ $event }}" instance="event" size="fa-lg"></favorite>
                        </div>
                    </div>
                </div>

                <comments
                    @added="commentsCount++"
                    @removed="commentsCount--">
                </comments>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This event was published {{ $event->created_at->diffForHumans() }} by
                            <a href="#">{{ $event->creator->name }}</a>, and currently
                            has <span v-text="commentsCount"></span> {{ Str::plural('comment', $event->comments_count) }}.
                        </p>
                        @role('Super Admin')
                            <p v-if="! locked">
                                <button class="btn btn-outline-secondary" @click="lock">Lock</button>
                            </p>
                            <p v-else>
                                <button class="btn btn-outline-secondary" @click="unlock">Unlock</button>
                            </p>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</event-view>
@endsection
