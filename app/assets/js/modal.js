const btnAbrirModal = document.getElementById("btn-modal");
const btnFecharModal = document.getElementById("fecharX");
const form = document.getElementById("form");

form.addEventListener("submit", (e)=>{
    location.reload();
});

btnAbrirModal.addEventListener("click", abrir);
btnFecharModal.addEventListener("click", fechar);

function abrir(){
    let modal = document.getElementById('modal');

    modal.className = 'modal-container mostrar';
}

function fechar(){
    let modal = document.getElementById("modal");

    modal.className = 'modal-container';
}