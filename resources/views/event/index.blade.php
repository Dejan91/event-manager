@extends('layouts.app')

@section('filters')
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Filter <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ url('/event?commented=1') }}">
                Most Commented
            </a>
        </div>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
            <div class="mt-2 mb-2">
                <range-picker></range-picker>
            </div>
            <ul class="event-list">
                @foreach ($events as $event)
                    <li>
                        <time datetime="2014-07-31 1600">
                            <span class="day">{{ $event->start_date->format('d') }}</span>
                            <span class="month">{{ $event->start_date->format('M') }}</span>
                        </time>
                        <img alt="My 24th Birthday!" src="{{ $event->image_path }}" />
                        <div class="info">
                            <h2 class="title">{{ Str::limit($event->title, 30, '...') }}</h2>
                            <p class="desc">{{ Str::limit($event->description, 100, '...') }}</p>
                            <ul>
                                <li style="width:33%;">{{ $event->subscribersCount }}  <span class="fa fa-male"></span></li>
                                <li style="width:34%;"><a href="{{ $event->path() }}">Show More  <span class="fa fa-info-circle"></span></a></li>
                            </ul>
                        </div>
                        <div class="social">
                            <ul>
                                <li id="favoriteEvent" class="facebook" style="width:33%;"><a href="#"><span class="fa fa-heart">{{ $event->favorites_count }}</span></a></li>
                                <li class="twitter" style="width:34%;"><a href="#"><span class="fa fa-comment">{{ $event->comments_count }}</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
