document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let countries = loadCountries();

    let calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid', 'interaction' ],

        dateClick: function(info) {
            if (! userHavePermission()) {
               return;
            }

            $.ajax({
                type: 'GET',
                url: '/event/create',
                data: {
                    start_date: info.dateStr
                },
                success: function (data) {
                    $('.modal-content').html(data);
                    $('#createEventModal').modal('show');
                    new SlimSelect({
                        select: '#country',
                        searchingText: 'Searching...',
                        data: countries
                    });
                },
                error: function (error) {
                    if (verificationEmailError(error)) {
                        $('.modal-content').html(verifyMailHTML());
                        $('#createEventModal').modal('show');
                    }
                }
            });

            sendVerificationEmailModal();

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
                            country: data.event.country,
                            start: data.event.start_date,
                            end: data.event.end_date
                        });
                        $('#createEventModal').modal('hide');
                        flash(data.success);
                    },
                    error: function (error){
                        showErrorMessage(error.responseJSON.errors);
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
                        let select = new SlimSelect({
                            select: '#country',
                            searchingText: 'Searching...',
                            data: countries
                        });
                        select.set(event.event.extendedProps.country_id);
                    },
                    error: function (error) {
                        if (verificationEmailError(error)) {
                            $('.modal-content').html(verifyMailHTML());
                            $('#createEventModal').modal('show');
                        }
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
                        error: function (error){
                            showErrorMessage(error.responseJSON.errors);
                        }
                    });
                });

                $(document).off('click', '#editEvent');
                $(document).on('click', '#editEvent', function (e) {
                    e.preventDefault();

                    let title = $('#title').val();
                    let description = $('#description').val();
                    let country = $('#country').val();
                    let start_date = $('#start_date').val();
                    let end_date = $('#end_date').val();

                    $.ajax({
                        type:'PUT',
                        url: '/event/update/' + event.event.id,
                        data: JSON.stringify({
                            title,
                            description,
                            country,
                            start_date,
                            end_date
                        }),
                        contentType : 'application/json',
                        success: function(data){
                            $('#createEventModal').modal('hide');
                            flash('Event updated');
                        },
                        error: function (error){
                            showErrorMessage(error.responseJSON.errors);
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
            result = events.events.map(event => {
                return {
                    id: event.id,
                    title: event.title,
                    description: event.description,
                    country_id: event.country_id,
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

function sendVerificationEmailModal() {
    $(document).off('click', '#resendVerification');
    $(document).on('click', '#resendVerification', function (e) {
        e.preventDefault();

        $('#createEventModal').modal('hide');

        $.ajax({
            type:'POST',
            url: 'email/resend',
            success: function(data){
                flash('Verification email resent.');
            },
            error: function (error){
                alert('There was an error resending your verification email.');
            }
        });
    });
}

function verifyMailHTML() {
    return `
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Verify Your Email Address</h5>
            </div>
            <div class="modal-body">
                <p>Before proceeding, please check your email for a verification link</p>
                <p>If you did not receive the email</p>
                <button type="submit" id="resendVerification" class="btn btn-link p-0 m-0 align-baseline">Click here to request another</button>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    `;
}

function verificationEmailError(error) {
    if (error.responseJSON.message === "Your email address is not verified.") {
        return true;
    }
    return false;
}
