$(document).ready(function () {
    $('.submit').click(function () {
        let discount = $(this).parents('.discount');
        discount.addClass('inactive');
        $(this).addClass('disabled').text('Submitted');
        console.log(discount);
        discount.fadeOut();
        //ajax logic wil be here soon
    });
});