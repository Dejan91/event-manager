<div class="modal-header">
    <h5 class="modal-title" id="createEventModal">Manage Events</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="alert alert-danger print-error-msg" style="display:none">
        <div></div>
    </div>

    <form id="eventForm">
        @csrf
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $event->title }}">
        </div>
        <div class="form-group">
            <label for="description">Event description</label>
            <textarea name="description" id="description" class="form-control" rows="5">{{ $event->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="country">Select country</label>
            <select id="country" name="country"></select>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="start_date">Starting date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $event->start_date->format('Y-m-d') }}">
            </div>
            <div class="form-group col-md-6">
                <label for="end_date">Ending date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $event->end_date->format('Y-m-d') }}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success submitBtn" id="eventDetails">Show Details</button>
            @can('update', $event)
                <button type="button" class="btn btn-warning submitBtn" id="editEvent">Edit Event</button>
                <button type="button" class="btn btn-danger submitBtn" id="deleteEvent">Delete Event</button>
            @endcan
        </div>
    </form>
</div>
