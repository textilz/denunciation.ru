


// Редактирование - редактировать
document.querySelector('.edit').addEventListener('click', (e) => {
    e.preventDefault()
    document.querySelectorAll('.edit-place').forEach(element => {
        element.classList.add('hide')
    });

    document.querySelectorAll('.input-place').forEach(element => {
        element.classList.remove('hide')
    })

})
// Редактирование - отменить
document.querySelector('.button_cancel').addEventListener('click', (e) => {
    e.preventDefault()
    document.querySelectorAll('.edit-place').forEach(element => {
        element.classList.remove('hide')
    });

    document.querySelectorAll('.input-place').forEach(element => {
        element.classList.add('hide')
    })

})

