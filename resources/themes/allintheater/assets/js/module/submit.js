export default function submitInqiry() {
  const sendUrl = '/wp-json/api/inquiry'
  const button = document.querySelector('#contact .submit')
  const sendedModal = document.querySelector('.inquiry-complete')

  const closeModalButton = document.querySelector(
    '.inquiry-complete .modal .close'
  )
  // let sendFlag = false
  // let errorMessages = [];

  if (button) {
    button.addEventListener('click', () => {
      // return;
      // validation
      // if (sendFlag) {
      //   // console.info('sendFlg:' + sendFlag);
      //   return
      // }

      // input validation
      if (checkValidation()) {
        // console.info('checkValidation: Error;');
        return
      }

      // double transmit flag
      // sendFlag = true

      // send Post
      let uri = window.location.origin + sendUrl

      let data = {
        company_name: document.getElementById('company_name').value,
        inquiry_item: document.getElementById('inquiry_item').value,
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        inquiry: document.getElementById('inquiry').value
      }

      fetch(uri, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
          }
          // return response.json(); // レスポンスをJSONとしてパース
          return 'success'
        })
        .then(() => {
          // console.info(data); // パースしたデータを表示
          // console.info('success2');
          sendedModal.classList.add('sended')
          // sendFlag = false
        })
        .catch(() => {
          // console.error('There was an error!', error);
          // console.info('success3');
          // sendFlag = false
        })
    })
  }

  // close modal
  if (closeModalButton) {
    closeModalButton.addEventListener('click', () => {
      // clear value
      document.getElementById('company_name').value = ''
      document.getElementById('inquiry_item').selectedIndex = -1
      document.getElementById('name').value = ''
      document.getElementById('email').value = ''
      document.getElementById('inquiry').value = ''
      sendedModal.classList.remove('sended')
    })
  }

  function checkValidation() {
    // clear Error
    clearError()

    let result = false
    let isCompanyName = validateRequired('company_name')
    if (isCompanyName) {
      // error
      result = true
    }
    let isInquiryItem = validateRequired('inquiry_item')
    if (isInquiryItem) {
      // error
      result = true
    }
    let isName = validateRequired('name')
    if (isName) {
      // error
      result = true
    }
    let isEmail = validateRequired('email')
    if (isEmail) {
      // error
      result = true
    } else {
      isEmail = validateEmail('email')
      if (isEmail) {
        // error
        result = true
      }
    }
    let isInquiry = validateRequired('inquiry')
    if (isInquiry) {
      // error
      result = true
    }

    return result
  }

  function validateRequired(id) {
    const input = document.getElementById(id)
    const val = input.value
    let isError = false

    if (val.trim() === '') {
      input.nextElementSibling.classList.add('show')
      input.nextElementSibling.innerHTML = '必須入力です。'
      isError = true
    }

    return isError
  }

  function validateEmail(id) {
    const input = document.getElementById(id)
    const val = input.value
    const regex = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]+.[A-Za-z0-9]+$/
    let isError = false

    if (!regex.test(val)) {
      input.nextElementSibling.classList.add('show')
      input.nextElementSibling.innerHTML =
        'メールアドレスの形式が正しくありません。'
      isError = true
    }

    return isError
  }

  function clearError() {
    let errors = document.querySelectorAll('.error')
    errors.forEach(function (error) {
      error.classList.remove('show')
    })
  }
}
