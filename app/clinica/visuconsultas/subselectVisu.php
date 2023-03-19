<?php
include_once('../../../conexao.php');

$paciente = $_GET['paciente'];

$sqlMedic = "select me.id_medico, me.nome from tb_medico as me join tb_paciente as pa on (me.id_medico = pa.id_medico) where me.id_clinica = 1 and pa.ativo = 'a' and me.ativo = 'a' and pa.id_paciente = ".$paciente;

$data = ['idPaciente' => $paciente];
// $query->execute($data);

$result_nome_medic = mysqli_query($conexao, $sqlMedic);

while($row_medic = mysqli_fetch_assoc($result_nome_medic)){ ?>
    <option value="<?php echo $row_medic['id_medico']; ?>"> <?php echo $row_medic['nome'] ?> </option> 
<?php }