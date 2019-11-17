document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid', 'interaction' ],

        dateClick: function(info) {
            if (! userHavePermission()) {
               return;
            }

            $.ajax({
                type: 'GET',
                url: '/event/create',
                success: function (data) {
                    $('.modal-content').html(data);
                    $('#createEventModal').modal('show');
                    new SlimSelect({
                        select: '#country',
                        searchingText: 'Searching...',
                        data: loadCountries()
                    });
                }
            });

            $(document).off('click', '#createEvent');
            $(document).on('click', '#createEvent', function (e) {
                e.preventDefault();

                $.ajax({
                    type:'POST',
                    url: '/event',
                    enctype: 'multipart/form-data',
                    data: new FormData($('#eventForm')[0]),
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function(data){
                        calendar.addEvent({
                            id: data.event.id,
                            user_id: data.event.user_id,
                            title: data.event.title,
                            description: data.event.description,
                            start: data.event.start_date,
                            end: data.event.end_date
                        });
                        $('#createEventModal').modal('hide');
                        flash(data.success);
                    },
                    error: function (data){
                        showErrorMessage(data.responseJSON.errors);
                    }
                });
            });
        },

        eventClick: function(event) {
            if (! userHavePermission()) {
                window.location = "/event/" + event.event.id;
            } else {
                $.ajax({
                    type: 'GET',
                    url: '/event/edit/' + event.event.id,
                    success: function (data) {
                        $('.modal-content').html(data);
                        $('#createEventModal').modal('show');
                        new SlimSelect({
                            select: '#country',
                            searchingText: 'Searching...',
                            data: loadCountries()
                        });
                    }
                });

                $(document).off('click', '#deleteEvent');
                $(document).on('click', '#deleteEvent', function (e) {
                    e.preventDefault();

                    $.ajax({
                        type:'DELETE',
                        url: '/event/' + event.event.id,
                        success: function(data){
                            event.event.remove();
                            $('#createEventModal').modal('hide');
                            flash(data.success);
                        },
                        error: function (data){
                            showErrorMessage(data.responseJSON.errors);
                        }
                    });
                });

                $(document).off('click', '#editEvent');
                $(document).on('click', '#editEvent', function (e) {
                    e.preventDefault();

                    let title = $('#title').val();
                    let description = $('#description').val();
                    let start_date = $('#start_date').val();
                    let end_date = $('#end_date').val();

                    $.ajax({
                        type:'PUT',
                        url: '/event/update/' + event.event.id,
                        data: JSON.stringify({
                            title,
                            description,
                            start_date,
                            end_date
                        }),
                        contentType : 'application/json',
                        success: function(data){
                            $('#createEventModal').modal('hide');
                            flash('Event updated');
                        }
                    });
                });

                $(document).off('click', '#eventDetails');
                $(document).on('click', '#eventDetails', function (e) {
                    e.preventDefault();
                    
                    window.location = "/event/" + event.event.id;
                });
            }
        },

        events: loadEvents()

    });

    calendar.render();

});


function loadEvents() {
    let result;
    $.ajax({
       type: 'GET',
       async: false,
       url: '/event',
       dataType: "json",
       success: function (events) {
            result = events.map(event => {
                return {
                    id: event.id,
                    title: event.title,
                    description: event.description,
                    start: event.start_date,
                    end: event.end_date
                }
            });
       }
    });
    return result;
}

function loadCountries() {
    let result;
    $.ajax({
        type: 'GET',
        async: false,
        url: '/country',
        success: function (countries) {
            result = countries.map(country => {
               return {
                   text: country.name,
                   value: country.id
               }
            });
        }
    });
    return result;
}

function userHavePermission() {
    if (user.roles[0].name === "Event Manager" || user.roles[0].name === "Super Admin") {
        return true;
    }
    return false;
}

function showErrorMessage (msg) {
    $(".print-error-msg").fadeIn();
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("div").append('<p>'+value+'</p>');
    });
    setTimeout(function () {
        $(".print-error-msg").fadeOut('slow');
        $(".print-error-msg").find("div").empty();
    }, 5000);
}

function showSuccessMessage(msg) {
    $('#message').fadeIn().html(msg.success);
    setTimeout(function() {
        $('#message').fadeOut("slow");
    }, 5000 );
}
