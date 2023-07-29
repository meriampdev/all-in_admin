// import Swiper from 'swiper/bundle';
import Swiper, { Autoplay, EffectFade } from 'swiper'
import 'swiper/swiper-bundle.css'

export default function slide() {
  document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.swiper-container', {
      // Optional parameters
      modules: [Autoplay, EffectFade],
      loop: true,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false
      },
      speed: 2500
    })

    // Then make swiper visible
    const swiperContainer = document.querySelector('.swiper-container')
    swiperContainer.style.visibility = 'visible'
    swiperContainer.style.opacity = '1'
  })
}
