<?php
	session_start();
	$logged = $_SESSION['clinica'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

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

	/* #Parte da edição de dados */
		if(!empty($_GET['id'])){
			
			$id = $_GET['id'];

			$sqlSelect = "select co.title, co.start, co.end, pa.id_paciente, me.id_medico, me.nome as fisio from tb_consulta as co join tb_medico as me on (me.id_medico = co.id_medico) join tb_paciente as pa on (pa.id_paciente = co.id_paciente) where co.id = ".$id;

			$result = $conexao->query($sqlSelect);

			if($result->num_rows > 0){
				while($user_data = mysqli_fetch_assoc($result)){
					$title = $user_data['title'];
					$inicio = $user_data['start'];
					$fim = $user_data['end'];
					$idPaciente = $user_data['id_paciente'];
					$idFisio = $user_data['id_medico'];
					$nmFisio = $user_data['fisio'];
				}
			}
			else{
				header('Location: visuconsulta.php.php');
			}
		}
	/* # */

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Atualizar Consulta</title>
		<link rel="icon" href="../../../img/logoicon.png">
		<meta charset="utf-8" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../../assets/css/main.css" />
	</head>
	<body class="is-preload">
		
		<!-- #sidebar -->
		<?php include('../sidebarClinicaPaste.php'); ?>

		<section class="home-section">

			<div class="home-content">
				<i class='bx bx-menu'></i>
				<span class="text">Editar <span>Consulta</span>
			</div>

			<!-- Content -->
			<div id="content">

				<div class="row">
					<div class="col-6" >
						<form action="../edit/saveAttConsulta.php" method="post">
							<div class="">
								<label class="form-label" for="idConsulta">ID:</label>
								<div class="input-group">
									<input class="form-control" type="text" name="idConsulta" value="<?php echo $id; ?>" readonly>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="title">Título:</label>
								<div class="input-group">
									<input class="form-control" type="text" name="title" value="<?php echo $title;?>">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="inicio">Data de início:</label>
								<div class="input-group">
									<input class="form-control" type="text" name="inicio" value="<?php echo date("d/m/Y H:i:s", strtotime($inicio));?>" onkeypress="DataHora(event, this)" required>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="fim">Data de término:</label>
								<div class="input-group">
									<input class="form-control" type="text" name="fim" value="<?php echo date("d/m/Y H:i:s", strtotime($fim));?>" onkeypress="DataHora(event, this)" required>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="form-label" for="paciEditVisu">Paciente:</label>
								<div class="input-group">
									<select name="paciEditVisu" id="paciEditVisu">
										<option>Selecione</option>
										<?php 
											$sql_paci_consulta = "select pa.id_paciente, pa.nome from tb_paciente as pa join tb_medico as me on (me.id_medico = pa.id_medico) join tb_clinica as cl on (cl.id_clinica = me.id_clinica) where cl.id_clinica = ".$idClinica;
											$result_paci_consulta = mysqli_query($conexao, $sql_paci_consulta);
											while($row_paci_consult = mysqli_fetch_assoc($result_paci_consulta)){ ?>
												<option <?php echo ($idPaciente==$row_paci_consult['id_paciente'])?'selected':'';?>  value="<?php echo $row_paci_consult['id_paciente']; ?>"> <?php echo $row_paci_consult['nome'] ?> </option> 
										<?php }?>
									</select>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label for="fisioEditVisu" class="labelInput">Nome do Fisioterapeuta: </label>
								<div class="input-group">
									<select class="select-agenda" name="fisioEditVisu" id="fisioEditVisu" readonly required>
										<option value=<?php echo $idFisio ?>><?php echo $nmFisio ?></option>
									</select>
								</div>
							</div>

							<div class="agenda-botao">
								<input class="concluir-btn visu" type="submit" value="Atualizar" name="atualizarConsulta">
							</div>

						</form>
					</div>
				</div> 

			</div>
		</section>
			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../../assets/js/jquery.min.js"></script>
			<script src="../../assets/js/browser.min.js"></script>
			<script src="../../assets/js/subselectVisu.js"></script>
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
<!-- #endregion -->

	</body>
</html>