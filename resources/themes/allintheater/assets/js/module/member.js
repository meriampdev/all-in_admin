export default function member() {
  const checkboxes = document.querySelectorAll(
      ".board-members .member .description input[type='checkbox']"
    ),
    memberDescriptions = document.querySelectorAll(
      '.board-members .member .description'
    )
  if (checkboxes) {
    checkboxes.forEach((element, idx) => {
      element.addEventListener('click', function (el) {
        el.preventDefault()

        // open
        memberDescriptions[idx].classList.add('open')
      })
    })
  }
}
