function clearRate() {
    $('.rate').each(function(e) {
        $(this).removeClass('rate_active')
    })
}

function addRate(rate) {
    clearRate()
    $('.rate_input').val(rate)
    $('.rate').each(function(e) {
        if (rate > e) {
            $(this).addClass('rate_active');
        }
    })
}

$('.rate').click(function(e) {
    addRate($(this).data('rate'))
})


$(document).ready(function(e) {
    $('.rate_input').val() != '' ? addRate($('.rate_input').val()) : null
})