$(function () {
    $('.dashboard-ico-block').click(function () {
        var href = $(this).find('a').attr('href');
        window.location.href = href;
    });
});
