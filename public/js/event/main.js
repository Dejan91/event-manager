$(document).ready(function () {
    $('#commentSearch').off('click');
    $('#commentSearch').on('click', function (e) {
        e.preventDefault();

        if (window.location.search === '') {
            window.location = `/event?commented=1`;
        } else {
            window.location = window.location + `&commented=1`;
        }
    });
});
