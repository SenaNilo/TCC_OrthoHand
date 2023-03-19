<?php
    include_once('../../../conexao.php');


    if(!empty($_POST['AttReg'])){
        $id = $_POST['id_paciente'];
        $historiaClinica = $_POST['historia_clinica'];
        $exameClinicaFisio = $_POST['exame_clinico'];
        $examesComplementares = $_POST['exame_complementar'];
        $diagnosticoFisio = $_POST['diagnostico_paciente'];
        $planoTerapeutico = $_POST['plano_fisio'];
        $evolucaoSaude = $_POST['evolucao_saude'];
        $dtRegistro = $_POST['data_registro'];

        $sqlCheck = "select re.id_registro from tb_registro as re join tb_paciente as pa on(re.id_paciente = pa.id_paciente) where pa.id_paciente = ".$id;

        $result = $conexao->query($sqlCheck);

        if($result->num_rows >0){
            //$UpOrInsert = 2; 2 para ATUALIZAR dados
            $sqlInsertReg = "call UpInsert_Registro(2, '$historiaClinica', '$exameClinicaFisio','$examesComplementares', '$diagnosticoFisio', '$planoTerapeutico', '$evolucaoSaude', '$dtRegistro', '$id')";
            $resultReg = $conexao->query($sqlInsertReg); 
        }else{
            //$UpOrInsert = 1; 1 para INSERIR dados
            $sqlUpdateReg = "call UpInsert_Registro(1, '$historiaClinica', '$exameClinicaFisio','$examesComplementares', '$diagnosticoFisio', '$planoTerapeutico', '$evolucaoSaude', '$dtRegistro', '$id')";
            $resultRegin = $conexao->query($sqlUpdateReg);
        }
    }
    header('Location: ../indexmedic.php');
?>