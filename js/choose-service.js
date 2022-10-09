$('.founded-services_input').keyup((e) => {
    $.ajax({
        url: 'action/get-services.php',
        type: 'POST',
        data: { textService: $('.founded-services_input').val() },
        dataType: 'JSON'
    }).done((res) => {
        $('.founded-services').addClass('founded-services_show')
        $('.founded-services').empty()
        res.forEach(element => {
            $('.founded-services').append(`<p class="founded-services__item" data-id="${element.id_services}">${element.name}</p>`)
            
        });
    }).fail((res) => {
        alert('Ошибка, попробуйте позже')
    })
})

$(window).click((e) => {
    if (e.target.className != 'founded-services_input' && e.target.className == 'founded-services__item') {

        $('.choose-service-block h2').html(e.target.textContent)
        $('.input-place_genre').val(e.target.dataset.id)

        $.ajax({
            url: 'action/get-service-image.php',
            type: 'POST',
            data: { idService: e.target.dataset.id },
            dataType: 'html'
        }).done((res) => {
            let image = new Image();
            image.src = 'data:image/png;base64,' + res;
            $('.find-service_image').empty()
            $('.find-service_image').append(image)
        }).fail((err) => {
        })

        $('.founded-services_input').val(e.target.textContent)
        $('.service_sort').val(e.target.dataset.id)

        $('.founded-services').removeClass('founded-services_show')
    } else if (e.target.className == 'founded-services_input') {
        console.log('все норм');
    } else {
        $('.founded-services').removeClass('founded-services_show')
    }
})