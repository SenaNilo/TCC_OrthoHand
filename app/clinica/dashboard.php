<?php
	session_start();
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

	/* Contador fisioterapeuta */ 

		$sqlcontME = "Select count(id_medico) as contfisio FROM tb_medico where id_clinica = $idClinica";

		$resultselectME = $conexao->query($sqlcontME); 
		while($row = mysqli_fetch_array($resultselectME)){
			$contfisio = $row['contfisio']; 
		}
	/* * */

	
	/* Contador pacientes */ 

		$sqlcontPA = "Select count(pa.id_paciente) as contpaci FROM tb_paciente as pa join tb_medico as me on (me.id_medico = pa.id_medico) where me.id_clinica = $idClinica";

		$resultselectPA = $conexao->query($sqlcontPA); 
		while($row = mysqli_fetch_array($resultselectPA)){

			$contpaci = $row['contpaci']; 			
		}
		
		//trazendo as informações e a pesquisa
		// O SQLVISUDASHBOARD é para puxar as informações do paciente
		$sqlVisuDashbord = "select pa.id_paciente, pa.nome, pa.img, pa.cpf, pa.ativo, me.nome as medico from tb_paciente as pa join tb_medico as me on (pa.id_medico = me.id_medico) where me.id_clinica = $idClinica";
		
		$sr = mysqli_query($conexao,$sqlVisuDashbord) or die("Erro ao executar a consulta" . mysqli_error($conexao));
	/* # */

	/* Ativar ou desativar paciente */
		if(isset($_POST['onOff'])){
			$idPaciente = $_POST['idPaciente'];

			$sqlAI = "select ativo from tb_paciente where id_paciente = $idPaciente;";

			$resultAI = $conexao->query($sqlAI);
			while($row = mysqli_fetch_array($resultAI)){
				$ativo = $row['ativo'];
			}

			if($ativo == 'a'){
				$sqlUpdatePaciAI = "update tb_paciente set ativo = 'i' where id_paciente = $idPaciente";

				$result = $conexao->query($sqlUpdatePaciAI);
			}else{
				$sqlUpdatePaciAI = "update tb_paciente set ativo = 'a' where id_paciente = $idPaciente";

				$result = $conexao->query($sqlUpdatePaciAI);
			}
			header("Refresh:0");
		}
	/* # */

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Dashboard</title>
		<link rel="icon" href="../../img/logoicon.png">
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">
		
		<!-- #sidebar -->
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
				<span class="text">Dashboard</span>
    		</div>
			
			<div id="content">

                <ul class="box-info">
                    <li>
						<i class='bx bxs-group'></i>
                        <span class="text">
                            <h3><?php echo $contpaci ?></h3>
                            <p>Pacientes</p>
                        </span>
                    </li>
                    <li>
						<i class='bx bx-plus-medical'></i>
                        <span class="text">
                            <h3> <?php echo $contfisio?> </h3>
                            <p>Fisioterapeutas</p>
                        </span>
                    </li>
			    </ul>


			    <div class="table-data">
                    <div class="order">

                        <div class="head">
                            <h3>Consultas</h3>
                            <i class='bx bx-search' ></i>
                            <i class='bx bx-filter' ></i>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Paciente</th>
									<th>CPF</th>
									<th>Fisioterapeuta</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php while ($dado = mysqli_fetch_assoc($sr)){
									if($dado['ativo'] == "a"){
										$ativoNome = 'Ativo';
										$className = 'completed';
									} else {
										$ativoNome = 'Inativo';
										$className = 'pending';
									}
									$ImgMedic = $dado['img'];
									if($ImgMedic != null){
										$ImgPerfil = "../fotos/$ImgMedic";
									}else{
										$ImgPerfil = "../fotos/fotoperfilvazia.jpg";
									} ?>
                                <tr>
                                    <td> 
                                        <img src="<?php echo $ImgPerfil ?>" alt="">
                                        <p><?php  echo $dado["nome"];?> </p>
                                    </td>
									<td><?php echo cpf($dado["cpf"]);?></td>
									<td><?php echo $dado["medico"]; ?></td>
                                    <td>
										<!-- <form method="post"> -->
											<input style="display: none;" type="text" name="idPaciente" value="<?php echo $dado['id_paciente']?>" readonly>
											<button class="btn-onoff" onclick="alertar(<?php echo $dado['id_paciente'] ?>)">
												<span class="status <?php echo $className?>"><?php echo $ativoNome; ?></span>
											</button>
										<!-- </form> -->
									</td>
                                </tr>
                                    
								<?php } ?> 
                            </tbody>
                        </table>

                    </div>                    
		</section>

		<!-- #region JANELA MODAL JS -->
			<div id="modal" class="modal-container">
				<div class="modal">
					<button id="fecharX" class="fechar">x</button>
					<div style="text-align: center; margin-top: 15px;">
						<span class="text"> Deseja mudar o status (ativo ou inativo) do paciente? </span>

						<div class="buttons-align">
							<form method="post">
								<input style="display: none;" type="text" name="idPaciente" value="" id="dashPacienteStatus" readonly>
								<div class="confirm-div-dash">								<button class="btn-confirm-dash" type="submit" name="onOff">Sim</button>
								</div>
							</form>

							<div class="confirm-div-dash">
								<button class="btn-confirm-dash" id="naoDash">Não</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- #endregion -->
			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/relogio.js"></script>
            <script src="../assets/js/dashboard.js"></script>
			<script src="../assets/js/modalDash.js"></script>
			<!-- #Script Sidebar -->
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

	</body>
</html>

<!-- Para o dashboard  https://www.youtube.com/watch?v=CkVrmLLHmuI -->