// Фикисированный блок
const fixed = document.querySelector('.fixed')
const fixedBlock = document.querySelector('.fixed-block')

fixedBlock.style.width = fixed.offsetWidth + 'px'

window.onscroll = function () {
    if (window.pageYOffset > 105) {
        fixedBlock.style.position = 'absolute'
        fixedBlock.style.top = parseInt(window.pageYOffset + 20) + 'px'
    } else {
        fixedBlock.style.position = 'unset'
        fixedBlock.style.top = 'unset'
    }
}