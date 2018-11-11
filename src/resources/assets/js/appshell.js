$(document).ready(function () {
    $('.nav-dropdown-toggle').on('click', function(e){
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });

    $('input[name="_method"][type="hidden"][value="DELETE"]')
        .parent('form')
        .on('submit', function (e) {
            var confirmText = $(this).data('confirmation-text') ? $(this).data('confirmation-text') : 'Are you sure you want to delete this item?';

            if (!confirm(confirmText)) {
                e.preventDefault();
            }
        });

    // Poor man's solution for opened sidebar group if there's an active child
    $('#appshell-main-menu .nav-dropdown').each(function () {
        if ($(this).find('.active').length) {
            $(this).addClass('open');
        }
    })
});

