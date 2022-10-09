// Пост
const post = document.querySelector('.post')
const service = document.querySelector('.service-container')

// if (post.offsetHeight < service.offsetHeight) {
//     post.style.height = service.offsetHeight + 'px'
// }

// Редактирование высоты textarea
const textarea = document.querySelector('textarea')
const textareaHeight = textarea.offsetHeight

textarea.addEventListener('keyup', function () {
    if (this.scrollTop > 0) {
        this.style.height = this.scrollHeight + "px";
    }

    if (this.value == '') {
        this.style.height = textareaHeight + "px";
    }
});

// Редактирование высоты textarea в комментарии
const commentContent = document.querySelectorAll('.comment__content')

commentContent.forEach(function (element) {
    element.querySelector('textarea').style.height = element.querySelector('.comment__text').offsetHeight + 20 + 'px'
})

// Редактирование комментариев - редактировать


const comments = document.querySelectorAll('.comment form')

comments.forEach(function(comment) {
    comment.querySelector('.edit').addEventListener('click', (e) => {
        e.preventDefault()
        comment.querySelectorAll('.edit-place').forEach(element => {
            console.log('zfdljkngjsdbf');
            element.classList.add('hide')
        });
    
        comment.querySelectorAll('.input-place').forEach(element => {
            element.classList.remove('hide')
        })
    
    })
    // Редактирование комментариев - отменить
    comment.querySelector('.button_cancel').addEventListener('click', (e) => {
        e.preventDefault()
        comment.querySelectorAll('.edit-place').forEach(element => {
            element.classList.remove('hide')
        });
    
        comment.querySelectorAll('.input-place').forEach(element => {
            element.classList.add('hide')
        })
    
    })
})