var form = document.getElementById("form");
var email = document.getElementById("email");
var senha = document.getElementById("senha");

form.addEventListener("submit", (e) => {
    const emailValue = email.value.trim();
    const senhaValue = senha.value.trim();

    if(emailValue === "" || senhaValue === ""){
        checkInputs();
        e.preventDefault();
    }
    else{     
        checkInputs();
    }
});


function checkInputs(){
    const emailValue = email.value.trim();
    const senhaValue = senha.value.trim();

    if(emailValue === ""){
        //erro
        setErrorFor(email);
    } else{
        //certo
        setSucessFor(email)
    }

    if(senhaValue === ""){
        //erro
        setErrorFor(senha);
    } else{
        //certo
        setAlertFor(senha)
    }
}

function setErrorFor(input) {
    const inputBox = input.parentElement;

    inputBox.className = 'input-box error';
}

function setSucessFor(input){
    const inputBox = input.parentElement;

    inputBox.className = "input-box sucess";
}

function setAlertFor(input){
    const inputBox = input.parentElement;

    inputBox.className = "input-box alert";
}