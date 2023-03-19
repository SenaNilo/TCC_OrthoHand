<?php
	session_start();
	$logged = $_SESSION['clinica'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* #Pegar nome da Clinica */
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
		$sqlNm = "select cl.nome from tb_clinica as cl join tb_usuarios as us on (us.id_usuario = cl.id_usuario) where cl.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomeCli = $row['nome'];
		}
	/* # */
	/* #Pegar id da clinica */
		$sqlID = "Select id_clinica from tb_clinica where id_usuario =".$idUsu;
			
		$resultID = $conexao->query($sqlID);
		while($row = mysqli_fetch_array($resultID)){
			$idClinica = $row['id_clinica'];
		}
		$_SESSION['id_clinica'] = $idClinica;
	/* # */

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $nomeCli ?> System</title>
		<link rel="icon" href="../../img/logoicon.png">
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">
		
		<!-- sidebar -->
		<?php include('sidebarClinica.php'); ?>

		<!-- Content -->
		<section class="home-section">
			<!-- Parte do relógio -->
			<div class="relogio">
				<div>
					<span id="horas">00</span>
					<span class="tempo">Horas</span>
				</div>

				<div>
					<span id="minutos">00</span>
					<span class="tempo">Minutos</span>
				</div>

				<div>
					<span id="segundos">00</span>
					<span class="tempo">Segundos</span>
				</div>
			</div>

	
			<div class="home-content">
				<i class='bx bx-menu'></i>
				<span class="text"><span>Seja</span> Bem-vindo!</span>
    		</div>
			
			<div id="content">
				<div class="agroup-clinica-tools">
					<div class="box manter">
						<center><h2> Manter pacientes </h2></center>
						<div class="btn-view">
							<a href="pacientes.php" class="chat-btn">Visualizar</a>
						</div>
					</div>

					<div class="box manter">
						<center><h2> Manter fisioterapeuta </h2></center>
						<div class="btn-view">
							<a href="medicFisio.php" class="chat-btn">Visualizar</a>
						</div>
					</div>

					<div class="box manter">
						<center><h2> Agendamento </h2></center>
						<div class="btn-view">
							<a href="agenda/agenda.php" class="chat-btn">Visualizar</a>
						</div>
					</div>

					<div class="box manter">
						<center><h2> Dashboard </h2></center>
						<div class="btn-view">
							<a href="dashboard.php" class="chat-btn">Visualizar</a>
						</div>
					</div>
				</div>
			</div>
		</section>
			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/relogio.js"></script>
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