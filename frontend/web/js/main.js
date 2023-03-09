$.ajaxPrefilter(function (options, originalOptions, jqXHR) { options.async = true; });

$(document).ready(function () {
    $('.navbar-toggler-icon').click(function (e) {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $('.logout').hide();
        } else {
            $(this).addClass('open');
            $('.logout').show();
        }
    });
});