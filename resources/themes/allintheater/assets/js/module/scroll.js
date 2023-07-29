export default function scroll() {
  window.addEventListener('scroll', function () {
    var element = document.querySelector('.content__section.mainmv')
    if (window.scrollY >= 2000) {
      element.style.display = 'none'
    } else {
      element.style.display = 'block'
    }
  })
}
