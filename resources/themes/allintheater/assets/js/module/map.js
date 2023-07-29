export default function map() {
  // TO MAKE THE MAP APPEAR YOU MUST
  // ADD YOUR ACCESS TOKEN FROM
  // https://account.mapbox.com
  mapboxgl.accessToken =
    'pk.eyJ1Ijoid3VudGFtYSIsImEiOiJjbGliMDdqY3kwM2V0M3BzMTByaDBpazRoIn0.2OC3OI6DBLZcl61AeuRQyg'
  const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/wuntama/clib09z95011r01rhbwe47x2j', // style URL
    center: [139.70463826879143, 35.65801091775077], // starting position [lng, lat]
    zoom: 17 // starting zoom
  })
  const htmlString =
    "<p class='map__name'>allintheater</p><span class='map__arrow'></span>"
  var markerElement = document.createElement('div')
  markerElement.innerHTML = htmlString
  markerElement.classList.add('map__object')
  var marker = new mapboxgl.Marker(markerElement)
    .setLngLat([139.70463826879143, 35.65801091775077]) // 会社の座標
    .addTo(map)

  var popup = new mapboxgl.Popup({ offset: 25 }).setHTML('<h3>会社名</h3>') // 会社名を表示

  // マーカーにポップアップを追加
  marker.setPopup(popup)
}
