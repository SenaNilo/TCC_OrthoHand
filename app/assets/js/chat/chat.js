const form = document.getElementById("form-chat"),
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); //Impedindo o envio do form
}

sendBtn.onclick = () => {
    //mais uma função chamando o ajax 
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) { // serve para verificar o estado da solicitação
            if (xhr.status === 200) { // serve para determinar se a solicitação foi brm sucedida
                inputField.value = ""; //Quando o usuario digitar a mensagem e enviar, deixe o campo de entrada branco
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

//Função pra quando o usuario mexer o scroll pra cima, ele permanecer, pq o ajax ta latente em 500ms, ent toda vez que tentar rolar pra cima, ele voltara pra ultima mensagem. Essa função vai fazer ele parar toda vez que o usuario mexer o scroll pra cima
chatBox.onmouseenter = () => {
    chatBox.classList.add("active")
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active")
}

setInterval(() => {
    // Inciando o Ajax
    let xhr = new XMLHttpRequest(); //Criando um objeto XML
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);

}, 500); //Essa é uma função que vai ser repetida após 500ms

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}