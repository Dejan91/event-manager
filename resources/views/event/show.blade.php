@extends('layouts.app')

@section('content')
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
        
            @foreach ($comments as $comment)
                @include('event.comment')
            @endforeach
        
            <div class="mt-4">
                {{ $comments->links() }}
            </div>
        
            <form action="{{ "{$event->path()}/comments" }}" method="POST" class="mt-5">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" id="body" rows="5" placeholder="Have something to say?"></textarea>
                </div>
        
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This event was published {{ $event->created_at->diffForHumans() }} by
                        <a href="#">{{ $event->creator->name }}</a>, and currently 
                        has {{ $event->comments_count }} {{ Str::plural('comment', $event->comments_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection