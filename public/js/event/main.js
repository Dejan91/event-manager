$(document).ready(function () {
    $(document).off('click', '#commentSearch');
    $(document).on('click', '#commentSearch', function(e) {
        e.preventDefault();

        if (window.location.search === '') {
            window.location = `/event?commented=1`;
        } else {
            window.location = window.location + `&commented=1`;
        }
    });
});
