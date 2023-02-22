const form = document.querySelector(".typing-area")
const inputField = form.querySelector(".input-field")
const sendBtn = document.querySelector(".typing-area button")
const chatBox = document.querySelector(".chat-box")

form.onsubmit = (e)=>{
    e.preventDefault();
}

const scrollingDown = () => {
    chatBox.scrollTo(0, chatBox.scrollHeight)
}

const create_outgoing_msg_node = (message) => {
    return `
        <div class="chat outgoing">
            <div class="details">
                <p>${message}</p>
            </div>
        </div>

    `
}

const create_incoming_msg_node = (message) => {
    return `
        <div class="chat incoming">
            <img src=./images/${friendData.img} alt="">
            <div class="details">
                <p>${message}</p>
            </div>
        </div>
    `
}

const removeAllChildfromChatBox = () => {
    while(chatBox.firstChild ){
        chatBox.removeChild( chatBox.firstChild );
    }
}

const renderChat = (messages_array) => {
    removeAllChildfromChatBox()

    if(messages_array?.length === 0 || messages_array === null){
        chatBox.insertAdjacentHTML('beforeend', '<p style="text-align:center">最初のメッセージを送信しよう</p>')
        return;
    };

    messages_array.forEach(messageData => {
        if(messageData.outgoing_msg_id === Number(outgoing_id)){
            chatBox.insertAdjacentHTML('beforeend', create_outgoing_msg_node(messageData.msg))
        } else {
            chatBox.insertAdjacentHTML('beforeend', create_incoming_msg_node(messageData.msg))
        }
    })
}

// ページが読み込まれたら,レンダリングとフォーカス
renderChat(messages_onLoad);
inputField.focus();
scrollingDown()

inputField.onkeyup = () => {
    if(inputField.value !== ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

// 送信ボタンを押したときの処理
sendBtn.onclick = async () => {
    const message = inputField.value
    if(!message) return

    const sendFormDataOption = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            incoming_id,
            message
        })
    }

    try {
        await fetch("php/insert_chat.php", sendFormDataOption)


        // 最後にユーザーイベントをnoneにする
        sendBtn.classList.remove("active");
    } catch (error) {
        console.log(error)
    }

    // フォームを空に
    inputField.value = ""
}

// setIntervalで500sごとに更新する
//renderChatの実行
setInterval(async () => {
const getChatOption = {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        incoming_id,
        outgoing_id
    })
}

const res = await fetch("php/get_chat.php", getChatOption)
const {messages: messages_array} = await res.json()


renderChat(messages_array)


}, 500)