<?php
    include_once('../../../conexao.php');


    if(!empty($_POST['deletarPaci'])){

        $confirmacao = $_POST['confirmacao'];
        $idPaciente = $_POST['idPaci'];

        if($confirmacao === "Sim"){
            $sqlDelPaciente = "call spDelPaciente('$idPaciente')";
            $result = $conexao->query($sqlDelPaciente);
            echo "<script> alert('Usuário deletado com sucesso'); </script>";    
        }
        else{
            echo "<script> alert('Usuário não deletado'); </script>";    
        }

    }
    header('Location: ../pacientes.php');
?>