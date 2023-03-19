<?php
	session_start();
	$logged = $_SESSION['paciente'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* Formatar o telefone do usuario */
		function telefone($tel){
			return "(". substr($tel, 0, 2) .")" . substr($tel, 2, 5)."-". substr($tel, 7, 4);
		}
	/* * */

	/* #Pegar nome do paciente */
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
		$sqlNm = "select pa.id_paciente, pa.nome from tb_paciente as pa join tb_usuarios as us on (us.id_usuario = pa.id_usuario) where pa.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomePaci = $row['nome'];
			$idPaci = $row['id_paciente'];
		}
		
		$primeiroNome = explode(" ", $nomePaci);
	/* # */

	/* #Pegar dados do paciente */
		$txt_pesquisa = (isset($_POST["txt_pesquisa"]))?$_POST["txt_pesquisa"]:""; /* Pro TXT */

		$sqlDPacientes = "SELECT re.id_registro, me.nome as fisioterapeuta, cl.nome as clinica, cl.telefone, cl.endereco, re.plano_terapeutico, re.exames_complementares, se.dt_ultimo_registro FROM tb_medico as me join tb_clinica as cl on (cl.id_clinica = me.id_clinica) join tb_registro as re on (re.id_medico = me.id_medico) join tb_sessao as se on (se.id_registro = re.id_registro) join tb_paciente as pa on (pa.id_paciente = re.id_paciente) where re.id_paciente = ".$idPaci." and pa.ativo = 'a'";

		$resultDPaci = $conexao->query($sqlDPacientes) or die ($conexao->error);
		// print_r($resultDPaci->fetch_array());
		// while($row = mysqli_fetch_array($resultPaci)){
		// 	$nomePaciente = $row['nome'];
		// }
	/* # */
?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="icon" href="../../img/logoicon.png">
		<title>Protocolos OrtoHand</title>
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
				<span class="text">Bem Vindo, <span><?php echo current($primeiroNome); ?></span></span>
    		</div>

			<!-- Content -->
			<div id="contentpaciente">

				<!-- Search -->
					<form action="" method=""> 
						<div class="search_wrap search_wrap_1">
							<div class="search_box">
								<input type="text" class="input" name="txt_pesquisa" placeholder="Pesquise...">
								
								<div class="btn">
									<input class="" type="submit" value="">
									<img src="../img/magnifying-glass-solid.svg">
								</div>
							</div>
						</div>	
					</form>

				
					<div class="agroup-patients">
						<?php if(mysqli_num_rows($resultDPaci) == 0){
							?><p class="no-data">Os dados ainda serão cadastrados! Tenha um bom dia!</p><?php
						} else{						
							while($dado = $resultDPaci->fetch_array()){ ?>
								<div class="box patients">
									<h2> <?php echo $dado['fisioterapeuta'] ?></h2>
									<h3> <span><?php echo $dado['clinica'] ?></span>:</h3>
									<p>• Telefone: <?php echo telefone($dado['telefone']) ?> </p>
									<p>• Endereço: <?php echo $dado['endereco'] ?> </p>
									<p> Última Consulta: <?php echo date("d/m/Y", strtotime($dado['dt_ultimo_registro'])) ?> </p>
									<p> Próxima Consulta: --/--/----</p>
									<div class="btn-chat-view">
										<a id="<?php echo $dado['id_registro'] ?>" onclick="alertar(<?php echo $dado['id_registro']?>)" class="view">Visualizar</a>
										<a href="chat/users.php" class="chat-btn">Chat</a>
									</div>
								</div>
							<?php }
						} ?>
					</div>
				
					<!-- #region Modal paci -->
					<div id="modalPaci" class="modalPaci-container">
						<div class="modalPaci">
							<button id="fecharX" onclick="fechar()" class="fecharPaci">x</button>
				
							<form id="form" method="POST">
								<div class="input-group">
									<h2 class="clinic-nome" id="clinica"></h2>
									<ul>
										<li id="tel">Telefone: 13997328919</li>
										<li id="end">Endereço: </li>
									</ul>
									<h2 id="medicName" class="medic-nome">Larissa Fernanda</h2>

									<!-- <div class="input-box">
										<input type="text" name="idRegistro" id="idRegistro" class="input-box" value="" readonly>
									</div> -->

									<div class="input-box">
										<label for="planoTerapeutico" class="labelInput">Plano terapeutico: </label>
										<textarea rows="3" type="text" name="planoTerapeutico" id="planoTerapeutico" class="text-area-detalhamento" value="" readonly></textarea>
									</div>

									<div class="input-box">
										<label for="examesComplementares" class="labelInput">Exames Complementares: </label>
										<textarea rows="3" type="text" name="examesComplementares" id="examesComplementares" class="text-area-detalhamento" readonly></textarea>
									</div>

									<div class="input-box">
										<label for="dtUltimaConsulta" class="labelInput">Última Consulta: </label>
										<input style="pointer-events: none;" type="date" rows="3" type="text" name="dtUltimaConsulta" id="dtUltimaConsulta" class="input-user" value="2005-08-24">
									</div>

									<div class="input-box">
										<label for="dtUltimaConsulta" class="labelInput">Próxima Consulta: </label>
										<input style="pointer-events: none;" type="date" rows="3" type="text" name="dtUltimaConsulta" id="dtUltimaConsulta" class="input-user" value="">
									</div>

									<hr class="modalHr">

									<div class="continue-button">
										<button onclick="fechar()" class="btn-cadastrar">Voltar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- #endregion -->

				</div>
			</div>
		</section>
			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/modalPaci.js"></script>
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
					sidebarBtn.addEventListener("click", () => {
					sidebar.classList.toggle("close");
					});
				</script>
			<!-- #end -->
<!-- #endregion -->

	</body>
</html>