<?php
    include_once('../../../conexao.php');


    if(!empty($_POST['deletarConsulta'])){
        $id = $_POST['idConsulta'];
        $confirmacao = $_POST['confirmacao'];
        $idConsulta = $_POST['idConsulta'];

        if($confirmacao === "Sim"){
            $sqlDelConsulta = "update tb_consulta set ativo = 'i' where id = ".$id;
            $result = $conexao->query($sqlDelConsulta);
        }
        else{
            header('Location: ../visuconsultas/visuconsulta.php');
        }
    }
    header('Location: ../visuconsultas/visuconsulta.php');
?>