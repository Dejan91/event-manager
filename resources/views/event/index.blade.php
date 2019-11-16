@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
            <ul class="event-list">
                @foreach ($events as $event)
                    <li>
                        <time datetime="2014-07-31 1600">
                            <span class="day">{{ $event->start_date->format('d') }}</span>
                            <span class="month">{{ $event->start_date->format('M') }}</span>
                        </time>
                        <img alt="My 24th Birthday!" src="{{ $event->image_path }}" />
                        <div class="info">
                            <h2 class="title">{{ Str::limit($event->title, 20, '...') }}</h2>
                            <p class="desc">{{ Str::limit($event->description, 50, '...') }}</p>
                            <ul>
                                <li style="width:33%;">333  <span class="fa fa-male"></span></li>
                                <li style="width:34%;"><a href="{{ $event->path() }}">details  <span class="fa fa-info-circle"></span></a></li>
                            </ul>
                        </div>
                        <div class="social">
                            <ul>
                                <li class="facebook" style="width:33%;"><a href="#"><span class="fa fa-heart">{{ $event->favorites_count }}</span></a></li>
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