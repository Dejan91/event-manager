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
                }
            });

            $('#createEventModal').modal('show');

            $(document).off('click', '#createEvent');
            $(document).on('click', '#createEvent', function (e) {
                e.preventDefault();

                $.ajax({
                    type:'POST',
                    url: '/event',
                    data: $('#eventForm').serialize(),
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
                        showSuccessMessage(data);
                    },
                    error: function (data){
                        showErrorMessage(data.responseJSON.errors);
                    }
                });
            });
        },

        eventClick: function(event) {
            if (! userHavePermission()) {
                return;
            }

            $.ajax({
                type: 'GET',
                url: '/event/edit/' + event.event.id,
                success: function (data) {
                    $('.modal-content').html(data);
                }
            });

            $('#createEventModal').modal('show');

            $(document).on('click', '#deleteEvent', function (e) {
                e.preventDefault();

                $.ajax({
                    type:'DELETE',
                    url: '/event/' + event.event.id,
                    success: function(data){
                        event.event.remove();
                        $('#createEventModal').modal('hide');
                        showSuccessMessage(data);
                    },
                    error: function (data){
                        showErrorMessage(data.responseJSON.errors);
                    }
                });

                $('#createEventModal').modal('hide');
            });

            $(document).on('click', '#editEvent', function (e) {
                e.preventDefault();

                // $("input[name$='letter']").val();
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
                        showSuccessMessage({success: 'Event Edited'});
                    }
                });
            });
        },

        events: loadEvents()

    });

    calendar.render();

});

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

function loadEvents() {
    let result;
    $.ajax({
       type: 'GET',
       async: false,
       url: '/event',
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

function userHavePermission() {
    let roles = user.roles.filter(role => {
        return role.name === 'Super Admin' || role.name === 'Event Manager';
    });
    return !roles.length <= 0;
}

function convertTime(str) {
    let date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day, ].join("-");
}
