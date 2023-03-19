<?php

include_once("../../../conexao.php");

if(isset($_GET['id'])){
    $idRegistro = $_GET['id'];

    $sqlDPacientes = "SELECT me.nome as fisioterapeuta, cl.nome as clinica, cl.telefone, cl.endereco, re.plano_terapeutico, re.exames_complementares, se.dt_ultimo_registro FROM tb_medico as me join tb_clinica as cl on (cl.id_clinica = me.id_clinica) join tb_registro as re on (re.id_medico = me.id_medico) join tb_sessao as se on (se.id_registro = re.id_registro) join tb_paciente as pa on (pa.id_paciente = re.id_paciente) where re.id_registro = ".$idRegistro." and pa.ativo = 'a'";

	$resultDPaci = $conexao->query($sqlDPacientes) or die ($conexao->error);
    
    $dados = $resultDPaci->fetch_array();

    // $dados = "Carro: ".$idRegistro; 

    $retorna = ['erro' => false, 'dado' => $dados];
}else{
    $retorna = ['erro' => true, 'dado' => $dados];
}
echo json_encode($retorna);