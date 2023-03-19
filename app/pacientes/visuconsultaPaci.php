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
		$txt_pesquisa_consulta = (isset($_POST["txt_pesquisa"]))?$_POST["txt_pesquisa"]:""; /* Pro TXT */

		$sqlConsultaPacientes = "select co.start as proxconsulta, fi.img, fi.nome as fisio, cl.nome as clinica, cl.endereco, cl.telefone from tb_consulta as co 
		join tb_paciente as pa on (pa.id_paciente = co.id_paciente)
		join tb_medico as fi on (fi.id_medico = co.id_medico)
		join tb_clinica as cl on (cl.id_clinica = fi.id_clinica)
			where pa.id_paciente = $idPaci and pa.ativo = 'a' and co.ativo = 'a' order by co.start";

		$resultConsultaPaci = $conexao->query($sqlConsultaPacientes) or die ($conexao->error);
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
				<span class="text">Consultas <span>Marcadas</span></span>
    		</div>

			<!-- Content -->
			<div id="contentpaciente">

                <form action="pacientes.php" method="post"> 
					<div class="search_wrap search_wrap_1">
						<div class="search_box">
							<input type="text" class="input" name="txt_pesquisa" placeholder="Pesquise aqui...">
							
							<div class="btn">
								<input class="" type="submit" value="">
								<img src="../img/magnifying-glass-solid.svg">
							</div>
						</div>
					</div>	
				</form>

				

                <div class="paci-consulta">

					
					
					<?php 
					if(mysqli_num_rows($resultConsultaPaci) == 0){
						echo "<p class='no-data'> Nenhuma consulta marcada, contate a clínica para marcar sua próxima consulta!</p>";
					}else{
						echo "<h1 class='prox-consulta-title'>Próxima Consulta:</h1><br>";
						while($row = $resultConsultaPaci->fetch_array()){ 
							$datatime = date("D M j G:i:s T Y", strtotime($row['proxconsulta']));
							$data = substr($datatime, 8, 2);
							$mes = substr($datatime, 4, 3);
							$horas = substr($row['proxconsulta'], 10, 4);
							$minutos = substr($row['proxconsulta'], 14, 2);

							$ImgMedic = $row['img'];
							if($ImgMedic != null){
								$ImgPerfil = "../fotos/$ImgMedic";
							}else{
								$ImgPerfil = "../fotos/fotoperfilvazia.jpg";
							}
							?>
							<div class="box-consulta">    
								<div class="day-consulta">
									<div class="hora-consulta"><?php echo $data . "<br>". $mes; ?></div>

									<div class="hora-consulta"> <?php echo $horas.$minutos . "h"?></div>
								</div>
								<div class="content-day">
									<div class="foto-fisio-consulta">
									<img src="<?php echo $ImgPerfil ?>" alt="fisioImg">
									</div>
									<div class="agroup-dados-consulta">
										
										<div class="nome-fisio-consulta">
											<?php echo $row['fisio'] ?>
										</div>
										
										<div class="informacoes-adicionais">
											<h3 class="info-clinica-consulta clinica-name"><?php echo $row['clinica'] ?></h3>
											<h3 class="info-clinica-consulta"><?php echo $row['endereco'] ?></h3>
											<h3 class="info-clinica-consulta"><?php echo telefone($row['telefone']) ?></h3>
										</div>
									</div>
								
								</div>
							</div>
					<?php }
					} ?>
                    
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