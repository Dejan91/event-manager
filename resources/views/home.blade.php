@extends('layouts.app')

@section('content')
<div class="container">
    <div id="message" class="alert alert-success" style="display: none" role="alert"></div>

    <div id='calendar'></div>

    <!-- Create Event Modal -->
    <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @include('event.modal.create')
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/fullcalendar/main.js') }}"></script>
    <script>
        let user = {!! $user !!};
    </script>
@endsection
