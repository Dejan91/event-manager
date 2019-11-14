@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($events as $event)
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">{{ $event->title }}</h5>
            </div>
            <div class="card-body">                
                <p class="card-text">{{ $event->description }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection