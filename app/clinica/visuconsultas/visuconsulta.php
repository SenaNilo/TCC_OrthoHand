<?php
	session_start(); /*  PÁGINA MERAMENTE ILUSTRATIVA PARA A BANCA -- DEPOIS DA 2ª BANCA, PODE RETIRAR ESSA PÁGINA  */
	$logged = $_SESSION['clinica'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* Funcao para o CPF do usuario */
		function cpf($cpf){
			return substr($cpf, 0, 3).".".substr($cpf, 3, 3).".".substr($cpf, 6,-2)."-".substr($cpf, -2);
		}
	/* * */


	/* #Pegar nome da Clinica */
		//Conexão com o banco
		include_once("../../../conexao.php");
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

	/* #Consulta */  //Pesquisa 
	$txt_pesquisa = (isset($_POST["txt_pesquisa"]))?$_POST["txt_pesquisa"]:"";
	//trazendo as informações e a pesquisa     
	  $sqlVisuAgenda = "select co.title, co.id, co.start, co.end, pa.nome as paciente, pa.cpf as cpfPaci, me.nome as fisio, me.cpf  as cpfFisio from tb_consulta as co join tb_clinica as cl on (co.id_clinica = cl.id_clinica) join tb_medico as me on (co.id_medico = me.id_medico) join tb_paciente as pa on (co.id_paciente = pa.id_paciente) where pa.ativo = 'a' and me.ativo = 'a' and cl.id_clinica = 1 and co.ativo = 'a' order by co.start";

	  
	  $sr = mysqli_query($conexao,$sqlVisuAgenda) or die("Erro ao executar a consulta" . mysqli_error($conexao));
/* # */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="icon" href="../../../img/logoicon.png">
		<title>Visualizar Consultas</title>
		<meta charset="utf-8" />+
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../../assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- #sidebar -->
		<?php include('../sidebarClinicaPaste.php'); ?>


		<section class="home-section">
		
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
				<span class="text">Visualizar <span>Agenda</span></span>
    		</div>

			<!-- Content -->
			<div id="content">
				
				<form action="pacientes.php" method="post"> 
					<div class="search_wrap search_wrap_1">
						<div class="search_box">
							<input type="text" class="input" name="txt_pesquisa" placeholder="Pesquise pelo nome ou cpf...">
							
							<div class="btn">
								<input class="" type="submit" value="">
								<img src="../../img/magnifying-glass-solid.svg">
							</div>
						</div>
					</div>	
				</form>

				<!-- #region Tabela -->
					<table id="keywords" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
							<th>Título</th>
							<th>Começo da consulta</th>
							<th>Final da consulta</th>
							<th>Paciente</th>
							<th>CPF do paciente</th>
							<th>Fisioterapeuta</th>
							<th>CPF do fisioterapeuta</th>

							<th>Alterar Dados</th>
							</tr>
						</thead>
						<tbody>
						<?php while($dado = mysqli_fetch_assoc($sr)){ ?>
							<tr>
								<td class="lalign"><?php echo $dado["title"];?></td>
								
								<td><?php echo date("d/m/Y H:i:s", strtotime($dado["start"]));?></td>

								<td><?php echo date("d/m/Y H:i:s", strtotime($dado["end"]));?></td>

								<td><?php echo $dado["paciente"]; ?></td>

								<!-- <td><?php //echo date("d/m/Y", strtotime($dado["dt_nascimento"]));?></td> -->

								<td><?php echo cpf($dado["cpfPaci"]);?></td>

								<td><?php echo $dado["fisio"];?></td>

								<td><?php echo cpf($dado["cpfFisio"]);?></td>
								

								<td>
									<a href='editarconsulta.php?id=<?php echo $dado['id']?>'><button>Alterar</button></a>
									<a href='deletarconsulta.php?id=<?php echo $dado['id']?>'><button class="btn-del">Deletar</button></a>
								</td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				<!-- #endregion -->
				
			</div>
		</section>

<!-- Scripts -->
	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/browser.min.js"></script>
	<!-- <script src="../../assets/js/calendario.js"></script> -->
	<script src="../../assets/js/relogio.js"></script>
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
				// console.log(sidebarBtn);
				sidebarBtn.addEventListener("click", () => {
				sidebar.classList.toggle("close");
				});
			</script>
		<!-- #end -->
<!-- EndScripts -->
</body>
</html>
