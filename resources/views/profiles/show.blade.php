@extends('profiles.profile')

@section('profile')
    <h4>Activity Log</h4>
    <div class="activity-feed">
        @foreach($activities as $date => $activity)
            <div class="feed-item">
                    <div class="date">{{ \Carbon\Carbon::parse($date)->format('M-d') }}</div>
                @foreach($activity as $record)
                    @if(view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
