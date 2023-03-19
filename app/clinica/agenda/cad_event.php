<?php
session_start();
$idClinica = $_SESSION['id_clinica'];
include_once '../../../conexaoPdo.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$color = "#2980b9";

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
$data_start = str_replace('/', '-', $dados['start']);
$data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));
$startVal = substr($data_start, 11, 20);

$data_end = str_replace('/', '-', $dados['end']);
$data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));
$endVal = substr($data_end, 11, 20);

if((!empty($dados['title'])) && (!empty($dados['paciente'])) && (!empty($dados['nmfisio'])) && ($startVal != "00:00:00") && ($endVal != "00:00:00")){
    $query_event = "INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES (:title, :color, :start, :end, 'a',:id_medico, :id_paciente, :id_clinica)";

    $insert_event = $conn->prepare($query_event);
    $insert_event->bindParam(':title', $dados['title']);
    $insert_event->bindParam(':color', $color);
    $insert_event->bindParam(':start', $data_start_conv);
    $insert_event->bindParam(':end', $data_end_conv);
    $insert_event->bindParam(':id_medico', $dados['nmfisio']);
    $insert_event->bindParam(':id_paciente', $dados['paciente']);
    $insert_event->bindParam(':id_clinica', $idClinica);

    if ($insert_event->execute()) {
        $retorna = ['sit' => true, 'msg' => '<div class="alert alert-success" role="alert">Evento cadastrado com sucesso!</div>'];
        // $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Evento cadastrado com sucesso!</div>';
        echo json_encode($retorna);
    } else {
        $retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Evento não foi cadastrado com sucesso!</div>'];
        echo json_encode($retorna);
    }
}else{
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Evento nao cadastrado com sucesso!</div>'];
    echo json_encode($retorna);
}


header('Content-Type: application/json');
