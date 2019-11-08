@extends('layouts.app')

@section('content')
<div class="container">
    <div id="message" class="alert alert-success" style="display: none" role="alert"></div>
    <!-- Modal -->
    <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModal">Make new event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <div></div>
                    </div>

                    <form method="POST" id="eventForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Event name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Event description</label>
                            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Starting date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="end_date">Ending date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary submitBtn" id="createEvent" onclick="submitForm()">Create event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id='calendar'></div>
</div>
@endsection

@section('scripts')
    <script>
        let user = {!! json_encode(['user' => $user]) !!};
    </script>
@endsection
