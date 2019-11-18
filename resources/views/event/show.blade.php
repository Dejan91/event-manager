@extends('layouts.app')

@section('content')
<event-view :initial-comments-count="{{ $event->comments_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{ $event->image_path }}" class="card-img-top" alt="Event Image" width="500" height="400">
                    <div class="card-body">
                        <h2 class="card-title">{{ $event->title }} at {{ $event->country->name }}</h2>
                        <p class="card-text">{{ $event->description }}</p>
                        <br>
                        <p><span class="font-weight-bold">Start: </span>{{ $event->start_date->format('Y-m-d') }}</p>
                        <p><span class="font-weight-bold">End: </span>{{ $event->end_date->format('Y-m-d') }}</p>
                    </div>
                </div>
            
                <comments :data="{{ $event->comments }}" 
                    @added="commentsCount++"
                    @removed="commentsCount--"></comments>
         
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This event was published {{ $event->created_at->diffForHumans() }} by
                            <a href="#">{{ $event->creator->name }}</a>, and currently 
                            has <span v-text="commentsCount"></span> {{ Str::plural('comment', $event->comments_count) }}.
                        </p>

                        <p>
                            {{-- <subscribe-button></subscribe-button> --}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</event-view>
@endsection