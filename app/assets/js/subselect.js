const selectPaciente = document.getElementById('paciente');
const selectPacienteEdit = document.getElementById('paciEdit');
const form = document.getElementById('addevent');

form.addEventListener('submit', (e)=>{
    var valorTitle = document.getElementById('title').value;
    var valorPaci = document.getElementById('paciente').value;
    var valorMedic = document.getElementById('nmfisio').value;
    var inicio = document.getElementById('start').value;
    var fim = document.getElementById('end').value;
    let start = inicio.substring(11, 20);
    let final = fim.substring(11, 20);


    if((valorTitle != "") && (valorPaci != "") && (valorMedic != "") && (start != "00:00:00") && (final != "00:00:00") && (start != "0:00:00") && (final != "0:00:00")){
        location.reload();
    }else{
        alert("Preencha os dados corretamente");
        e.preventDefault();
    }
    
});

selectPaciente.onchange = () => {
    let selectMedico = document.getElementById('nmfisio');
    
    let valor = selectPaciente.value;

    fetch("subselect.php?paciente=" + valor)
        .then( response => {
            return response.text();
        })
        .then(texto => {
            selectMedico.innerHTML = texto;
        });
}
selectPacienteEdit.onchange = () => {
    let selectMedicoEdit = document.getElementById('fisioEdit');
    
    let valor = selectPacienteEdit.value;

    fetch("subselect.php?paciente=" + valor)
        .then( response => {
            return response.text();
        })
        .then(texto => {
            selectMedicoEdit.innerHTML = texto;
        });
}