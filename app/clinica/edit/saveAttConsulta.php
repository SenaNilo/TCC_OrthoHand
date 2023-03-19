<?php
    include_once('../../../conexao.php');


    if(!empty($_POST['atualizarConsulta'])){
        $id = $_POST['idConsulta'];
        $title = $_POST['title'];
        $dtInicio = $_POST['inicio'];
        $dtFinal = $_POST['fim'];
        $idPaciente = $_POST['paciEditVisu'];
        $idFisio = $_POST['fisioEditVisu'];
        
        $data_start = str_replace('/', '-', $dtInicio);
        $data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));
        $startVal = substr($data_start, 11, 20);

        $data_end = str_replace('/', '-', $dtFinal);
        $data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));
        $endVal = substr($data_end, 11, 20);

        if((!empty($title)) && (!empty($idPaciente)) && (!empty($idFisio)) && ($startVal != "00:00:00") && ($endVal != "00:00:00")){
            $sqlUpdateConsulta = "update tb_consulta SET title= '$title', start = '$data_start_conv', end = '$data_end_conv', id_paciente = ".$idPaciente.", id_medico = ".$idFisio." WHERE id= ".$id;

            $result =+ $conexao->query($sqlUpdateConsulta);
        }
    }
    header('Location: ../visuconsultas/visuconsulta.php');
?>