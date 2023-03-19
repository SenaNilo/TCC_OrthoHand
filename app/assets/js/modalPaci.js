async function alertar(idcoisa){
    // document.getElementById('idRegistro').value = idcoisa;
    const dados = await fetch('visu/visualizar.php?id=' + idcoisa);
    const resposta = await dados.json();

    abrir();

    document.getElementById('clinica').innerHTML = resposta['dado'].clinica;
    document.getElementById('tel').innerHTML = "Telefone: " + resposta['dado'].telefone;
    document.getElementById('end').innerHTML = "Endereço: " + resposta['dado'].endereco;
    document.getElementById('medicName').innerHTML = "<span>Fisioterapeuta</span>: " + resposta['dado'].fisioterapeuta;
    document.getElementById('planoTerapeutico').innerHTML = resposta['dado'].plano_terapeutico;
    document.getElementById('examesComplementares').innerHTML = resposta['dado'].exames_complementares;
    document.getElementById('dtUltimaConsulta').innerHTML = "Ultima Consulta: " + resposta['dado'].dt_ultima_registro;
}


function abrir(){
    let modal = document.getElementById('modalPaci');

    modal.className = 'modalPaci-container mostrar';
}

function fechar(){
    let modal = document.getElementById("modalPaci");

    modal.className = 'modalPaci-container';
}