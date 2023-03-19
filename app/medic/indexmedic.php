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

		$primeiroNome = explode(" ", $nomeFisio);

	/* # */

	/* #Pegar id do médico e unique ID */
		$sqlID = "Select id_medico, unique_id from tb_medico where id_usuario =".$idUsu;
		
		$resultID = $conexao->query($sqlID);
		while($row = mysqli_fetch_array($resultID)){
			$idMedic = $row['id_medico'];
			$_SESSION['unique_id'] = $row['unique_id'];
		}
	/* # */

	/* #Pegar pacientes do medico */
		$txt_pesquisa = (isset($_POST["txt_pesquisa"]))?$_POST["txt_pesquisa"]:"";

		$sqlPacientes = "select pa.id_paciente, pa.unique_id, pa.nome, re.plano_terapeutico, re.exames_complementares, se.dt_ultimo_registro from tb_registro as re right join tb_paciente as pa on (pa.id_paciente = re.id_paciente) join tb_medico as me on (me.id_medico = pa.id_medico) left join tb_sessao as se on (se.id_registro = re.id_registro) where me.id_medico = ".$idMedic." and pa.ativo = 'a' and (pa.nome LIKE '{$txt_pesquisa}%')";

		$resultPaci = $conexao->query($sqlPacientes) or die ($conexao->error);
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
			<div id="content">

				<div class="index-medic">

					<!-- Search -->
					<form action="indexmedic.php" method="post"> 
						<div class="search_wrap search_wrap_1">
							<div class="search_box">
								<input type="text" class="input" name="txt_pesquisa" placeholder="Pesquise pelo nome...">
								
								<div class="btn">
									<input class="" type="submit" value="">
									<img src="../img/magnifying-glass-solid.svg">
								</div>
							</div>
						</div>	
					</form>

					<div class="agroup-patients">
						<?php while($dado = $resultPaci->fetch_array()){
							if($dado['dt_ultimo_registro'] == null){
								$dtUltimoRegistro = "[----/--/--]";
							}else{
								$dtUltimoRegistro = date("d/m/Y", strtotime($dado['dt_ultimo_registro']));
							}
							?>
							<div class="box patients">
								<h2><?php echo $dado['nome'] ?></h2>
								<p>Procedimento: <?php echo $dado['plano_terapeutico'] ?></p>
								<p>Exames: <?php echo $dado['exames_complementares'] ?></p>
								<p>Último registro do prontuário: <?php echo $dtUltimoRegistro ?></p>
								<div class="btn-chat-view">
									<a href="detalhamento.php?idPaci=<?php echo $dado['id_paciente'] ?>"><button class="view">Informações</button></a>
									<a href="chat/chat.php?id_usuario=<?php echo $dado['unique_id']?>" class="chat-btn">Chat</a>
									<!-- <a href = "chat.php?id_usuario='.$row['unique_id'].'" > -->
								</div>
							</div>
						<?php } ?>
					</div>

				</div>

			</div>
		</section>


<!-- #region Scripts -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/browser.min.js"></script>
	<script src="../assets/js/modalFisio.js"></script>
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