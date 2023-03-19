<?php
session_start();

include_once '../../../conexaoPdo.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
$data_start = str_replace('/', '-', $dados['start']);
$data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));
$startVal = substr($data_start, 11, 20);

$data_end = str_replace('/', '-', $dados['end']);
$data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));
$endVal = substr($data_end, 11, 20);


if((!empty($dados['title'])) && (!empty($dados['paciEdit'])) && (!empty($dados['fisioEdit'])) && ($startVal != "00:00:00") && ($endVal != "00:00:00")){

    $query_event = "UPDATE tb_consulta SET title = :title, start = :start, end = :end, id_medico = :id_medico, id_paciente = :id_paciente WHERE id = :id";

    $update_event = $conn->prepare($query_event);

    $update_event->bindParam(':title', $dados['title']);
    $update_event->bindParam(':start', $data_start_conv);
    $update_event->bindParam(':end', $data_end_conv);
    $update_event->bindParam(':id_medico', $dados['fisioEdit']);
    $update_event->bindParam(':id_paciente', $dados['paciEdit']);
    $update_event->bindParam(':id', $dados['id']);

    if ($update_event->execute()) {
        $retorna = ['sit' => true, 'msg' => 'Evento editado com sucesso!'];
        // $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Evento editado com sucesso!</div>';
    } else {
        $retorna = ['sit' => false, 'msg' => 'Evento não foi editado com sucesso!'];
    }
}

header('Content-Type: application/json');
echo json_encode($retorna);
