$(document).ready(function () {
    $('.nav-dropdown-toggle').on('click', function(e){
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });
});

