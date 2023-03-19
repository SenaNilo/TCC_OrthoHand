<?php
session_start();
$idClinica = $_SESSION['id_clinica'];
/**
 * @author Cesar Szpak - Celke - cesar@celke.com.br
 * @pagina desenvolvida usando FullCalendar e Bootstrap 4,
 * o código é aberto e o uso é free,
 * porém lembre-se de conceder os créditos ao desenvolvedor.
 */
include '../../../conexaoPdo.php';

$query_events = "select co.id, co.title, co.color, co.start, co.end, me.nome as fisioterapeuta, pa.nome as paciente from tb_consulta as co join tb_paciente as pa on (pa.id_paciente = co.id_paciente) join tb_medico as me on (me.id_medico = co.id_medico) join tb_clinica as cl on (cl.id_clinica = co.id_clinica) where co.ativo='a' and cl.id_clinica = ".$idClinica;
$resultado_events = $conn->prepare($query_events);
$resultado_events->execute();

$eventos = [];

while($row_events = $resultado_events->fetch(PDO::FETCH_ASSOC)){
    $id = $row_events['id'];
    $title = $row_events['title'];
    $color = $row_events['color'];
    $start = $row_events['start'];
    $end = $row_events['end'];
    $fisio = $row_events['fisioterapeuta'];
    $paci = $row_events['paciente'];
    
    $eventos[] = [
        'id' => $id, 
        'title' => $title, 
        'fisio' => $fisio, 
        'paci' => $paci,
        'color' => $color, 
        'start' => $start, 
        'end' => $end, 
        ];
}

echo json_encode($eventos);