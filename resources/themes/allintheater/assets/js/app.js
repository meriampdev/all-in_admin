/**
 * vewport-extraを有効にする場合はインストールしてコメントアウトを削除
 * npm i viewport-extra
 */

// import './module/viewport'
import submitInqiry from './module/submit'
import slide from './module/slide'
import menu from './module/menu'
import map from './module/map'
import member from './module/member'
import scroll from './module/scroll'
submitInqiry()
slide()
menu()
map()
member()
scroll()

// import Menu from './module/menu'
var className = 'inverted'
var scrollTrigger = 60

window.onscroll = function () {
  // We add pageYOffset for compatibility with IE.
  if (window.scrollY >= scrollTrigger || window.pageYOffset >= scrollTrigger) {
    document.getElementsByTagName('header')[0].classList.add(className)
  } else {
    document.getElementsByTagName('header')[0].classList.remove(className)
  }
}
