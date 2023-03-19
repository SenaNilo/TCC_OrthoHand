<?php
	session_start();
	$logged = $_SESSION['medico'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* #Pegar nome do medico */
		//Conexão com o banco
		include_once("../../conexao.php");
		//Pegar ID do usuario
		$sqlUsu = "SELECT id_usuario FROM tb_usuarios WHERE email = '$email' AND senha = '$senha'";

		//Executando p ver se existe
		$resultUsu = $conexao->query($sqlUsu);
		while($row = mysqli_fetch_array($resultUsu)){
			$idUsu = $row['id_usuario'];
		}
		
		//Pegar nome do usuario
		$sqlNm = "select me.nome from tb_medico as me join tb_usuarios as us on (us.id_usuario = me.id_usuario) where me.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomeFisio = $row['nome'];
		}
	/* # */

	/* #Pegar id do médico */
		$sqlID = "Select id_medico from tb_medico where id_usuario =".$idUsu;
			
		$resultID = $conexao->query($sqlID);
		while($row = mysqli_fetch_array($resultID)){
			$idMedic = $row['id_medico'];
		}
	/* # */

	/* #Pegar pacientes do medico */
		// $sqlPacientes = "select pa.nome, re.plano_terapeutico, re.exames_complementares, re.dt_registro from tb_registro as re join tb_paciente as pa on (pa.id_paciente = re.id_paciente) join tb_medico as me on (me.id_medico = re.id_medico) where me.id_medico = ".$idMedic;

		// $resultPaci = $conexao->query($sqlPacientes) or die ($conexao->error);
		// while($row = mysqli_fetch_array($resultPaci)){
		// 	$nomePaciente = $row['nome'];
		// }
	/* # */

	/* #Parte da edição de dados */
		if(!empty($_GET['idPaci'])){

			$idPaci = $_GET['idPaci'];	
		}
	/* # */

	/* #Pegar os dados do registro */
		$sqlRegistro = "select pa.nome, re.historia_clinica, re.exame_clinico_fisico, re.exames_complementares, se.diagnostico_fisio, re.plano_terapeutico, se.evolucao_saude, se.dt_ultimo_registro from tb_registro as re join tb_paciente as pa on (pa.id_paciente = re.id_paciente) join tb_medico as me on (me.id_medico = re.id_paciente) join tb_sessao as se on (se.id_registro = re.id_registro) where re.id_medico = ".$idMedic." and re.id_paciente = ".$idPaci;

		$resultReg = $conexao->query($sqlRegistro) or die ($conexao->error);
		$numRows = $resultReg->num_rows;
		if($numRows == 0){
			$nomeReg = null;
			$historiaClinica = null;
			$exameClinicaFisio = null;
			$examesComplementares = null;
			$diagnosticoFisio = null;
			$planoTerapeutico = null;
			$evolucaoSaude = null;
			$dtRegistro = null;
		}else{
			while($rowReg = mysqli_fetch_array($resultReg)){
				$nomeReg = $rowReg['nome'];
				$historiaClinica = $rowReg['historia_clinica'];
				$exameClinicaFisio = $rowReg['exame_clinico_fisico'];
				$examesComplementares = $rowReg['exames_complementares'];
				$diagnosticoFisio = $rowReg['diagnostico_fisio'];
				$planoTerapeutico = $rowReg['plano_terapeutico'];
				$evolucaoSaude = $rowReg['evolucao_saude'];
				$dtRegistro = $rowReg['dt_ultimo_registro'];
			}
		}
	/* * */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="icon" href="../../img/logoicon.png">
		<title>Detalhamentos Médico</title>
		<meta charset="utf-8" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">
		
		<!-- #sidebar -->
		<?php include('sidebar.php') ?>

		<section class="home-section">

			<div class="home-content">
				<i class='bx bx-menu'></i>
				<span class="text">Detalhamentos</span>
    		</div>

			<!-- Content -->
			<div id="content">

				<div class="backgroundtela">
					<h1>Nome do Paciente: <span><?php echo $nomeReg ?></span></h1>	
					<br><br>

					<form method="post" action="edit/saveAttReg.php">
						<div class="flex-container">	
								<input id="id_paciente" type="text" name="id_paciente" value="<?php echo $idPaci ?>" readonly>	
						</div>

						<div class="flex-container">
							<h1>História Clínica <span>*</span>: </h1>
							<textarea class="text-area-detalhamento" rows="4" cols="71" name="historia_clinica" id="descri" maxlength="1200" placeholder="Escreva aqui..." required><?php echo $historiaClinica ?></textarea>
						</div>

						<div class="flex-container">
							<h1>Exame Clínico <span>*</span>: </h1>
							<textarea class="text-area-detalhamento" rows="4" cols="71" name="exame_clinico" id="descri" maxlength="1200" placeholder="Escreva aqui..." required><?php echo $exameClinicaFisio ?></textarea>
						</div>

						<div class="flex-container">
							<h1>Exames Complementares <span>*</span>:</h1>
							<textarea class="text-area-detalhamento" rows="4" cols="71" name="exame_complementar" id="descri" maxlength="1200" placeholder="Escreva aqui..." required><?php echo $examesComplementares ?></textarea>
						</div>
						
						<div class="flex-container">
							<h1>Diagnóstico fisioterapêutico:</h1>
							<textarea class="text-area-detalhamento" rows="4" cols="71" name="diagnostico_paciente" id="descri" maxlength="1200" placeholder="Escreva aqui..." required><?php echo $diagnosticoFisio ?></textarea>
						</div>

						<div class="flex-container">
							<h1>Plano Fisioterapêutico:</h1>
							<textarea class="text-area-detalhamento" rows="4" cols="71" name="plano_fisio" id="descri" maxlength="1200" placeholder="Escreva aqui..." required><?php echo $planoTerapeutico ?></textarea>
						</div>

						<div class="flex-container">
							<h1>Evolução do Paciente (descrição do paciente ao decorrer dos procedimentos):</h1>
							<textarea class="text-area-detalhamento" rows="4" cols="71" name="evolucao_saude" id="descri" maxlength="1200" placeholder="Escreva aqui..." required><?php echo $evolucaoSaude ?></textarea>
						</div>

						<div class="flex-container">
							<label for="data" class="labelInput">Data do registro: </label>
							<input type="date" name="data_registro" id="dataReg" value="<?php echo $dtRegistro?>" class="inputUser" required>
						</div>

						<div class="flex-container">
							<div class="btn-alt-del">
								<a href="indexmedic.php" class="alterar">Voltar</a>
								<input type="submit" class="concluir-btn" value="Atualizar" name="AttReg">
							</div>    
						</div>
					</form>

				</div>

			</div>
	</section>
    
	
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<!-- #Script Sidebar -->
			<script>
					//SCRIPT EFEITOS SIDEBAR 
					let arrow = document.querySelectorAll(".arrow");
					for (var i = 0; i < arrow.length; i++) {
					arrow[i].addEventListener("click", (e) => {
						let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
						arrowParent.classList.toggle("showMenu");
					});
					}
					let sidebar = document.querySelector(".sidebar");
					let sidebarBtn = document.querySelector(".bx-menu");
					console.log(sidebarBtn);
					sidebarBtn.addEventListener("click", () => {
					sidebar.classList.toggle("close");
					});
				</script>
			<!-- #end -->
<!-- #endregion -->

	</body>
</html>