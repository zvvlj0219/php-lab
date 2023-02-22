const baseUrl = 'http://localhost/practice-php/php-lab/apps/chat_app'

const form = document.querySelector(".signup form")
const continueBtn = form.querySelector(".button input")
const errorText = form.querySelector(".error-text")

form.onsubmit = (e) => {
    e.preventDefault();
}

continueBtn.onclick = async () => {
    console.log('call')

    // FormDataにformを渡して
    // データを格納したFormDataを作成
    const formData = new FormData(form)

    const sendFormDataOption = {
        method: 'POST',
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        body: formData
    }

    // fetchでバイナリデータを送信する際
    // boundaryを正常に設定させるために
    // Content-Typeを削除する
    if (typeof sendFormDataOption.headers === 'undefined') return
    delete sendFormDataOption.headers['Content-Type']

    try {
        const res = await fetch("php/signup.php", sendFormDataOption)
        const data = await res.json()
        const {err_msg, registerdUser} = data

        if(err_msg){
            errorText.style.display = "block"
            errorText.textContent = err_msg
        }

        // 正常に処理が終了したらusers.phpへ遷移
        if(registerdUser) location.href = `${baseUrl}/users.php`
    } catch (error) {
        console.log(error)
    }
}