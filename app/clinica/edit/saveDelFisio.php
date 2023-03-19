<?php
    include_once('../../../conexao.php');


    if(!empty($_POST['deletarFisio'])){

        $confirmacao = $_POST['confirmacao'];
        $idFisio = $_POST['idFisio'];

        if($confirmacao === "Sim"){
            $sqlDelFisio = "call spDelFisio('$idFisio')";
            $result = $conexao->query($sqlDelFisio);
            echo "<script> alert('Usuário deletado com sucesso'); </script>";    
        }
        else{
            echo "<script> alert('Usuário não deletado'); </script>";    
        }

    }
    header('Location: ../medicFisio.php');
?>