$(document).ready(function () {
    $('.submit').click(function () {
        let id = $(this).attr('data-id');
        console.log(id);
        let discount = $(this).parents('.discount');
        discount.addClass('inactive');
        $(this).addClass('disabled').text('Submitted');

        $.ajax({
            method: "POST",
            url: "/submit_discount",
            dataType: "json",
            data: { id: id }
        })
            .done(function() {
                let counter = $('#counter');
                counter.text(counter.text() -1);
                discount.fadeOut();
            });
    });

    $('#reset_base').click(function () {
        $.ajax({
            method: "POST",
            url: "/reset_base",
            dataType: "json",
            data: { reset_base: true }
        })
            .done(function() {
                location.reload();
            });
    });

    $('#renew_data').click(function () {
        $.ajax({
            method: "POST",
            url: "/check_api",
            dataType: "json",
            data: { check_api: true }
        })
            .done(function() {
                location.reload();
            });
    });
});