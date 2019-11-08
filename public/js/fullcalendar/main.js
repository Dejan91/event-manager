document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid', 'interaction' ],

        dateClick: function(info) {
            $('#createEventModal').modal('show');
        },

        events: [
            { // this object will be "parsed" into an Event Object
                title: 'The Title', // a property!
                start: '2019-11-11', // a property!
                end: '2019-11-13' // a property! ** see important note below about 'end' **
            },
            { // this object will be "parsed" into an Event Object
                title: 'New Event', // a property!
                start: '2019-11-11', // a property!
                end: '2019-11-12' // a property! ** see important note below about 'end' **
            },
        ]


    });

    calendar.render();

    submitForm();

});


function submitForm() {
    const button = document.getElementById('createEvent')
    button.addEventListener('click', async (e) => {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url: '/event',
            data: $('#eventForm').serialize(),
            success:function(data){
                $('#createEventModal').modal('hide');
            },
            error: function (data)
            {
                console.log(data);
                if (data.status == '403') {
                    $(".print-error-msg").find("div").html('');
                    $(".print-error-msg").css('display','block');
                    $(".print-error-msg").find("div").append('<p>'+"You don't have right permissions for this action."+'</p>');
                    return;
                }
                printErrorMsg(data.responseJSON.errors);
            }
        });
    });
}

function printErrorMsg (msg) {
    $(".print-error-msg").find("div").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("div").append('<p>'+value+'</p>');
    });
}
