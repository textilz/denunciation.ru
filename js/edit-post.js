$('.service-block__edit-panel_edit').click((e) => {
    if ($(e.target).hasClass('edited')) {
        $('.service-block__edit-panel_edit').removeClass('edited')
        $('.service-block__edit-panel_edit').text('Редактировать пост')
        $('.edit-place-post').removeClass('hide')
        $('.input-place-post').addClass('hide')
    } else {
        $('.input-place-post_text').height($('.post-block__text').height())
        $('.service-block__edit-panel_edit').addClass('edited')
        $('.service-block__edit-panel_edit').text('Отменить редактирование')
        $('.edit-place-post').addClass('hide')
        $('.input-place-post').removeClass('hide')
    }
})