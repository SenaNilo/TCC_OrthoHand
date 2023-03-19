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

			$sqlSelect = "select us.email, pa.nome, pa.cpf, pa.dt_nascimento, pa.genero, pa.naturalidade, pa.estado_civil, me.id_medico, me.nome as 'medico' from  tb_usuarios as us join tb_paciente as pa on(us.id_usuario = pa.id_usuario) join tb_medico as me on (pa.id_medico = me.id_medico) where pa.id_paciente = $id";

			$result = $conexao->query($sqlSelect);

			if($result->num_rows > 0){
				while($user_data = mysqli_fetch_assoc($result)){
					$nome = $user_data['nome'];
					$cpf = $user_data['cpf'];
					$dt_nascimento = $user_data['dt_nascimento'];
					$genero = $user_data['genero'];
					$naturalidade = $user_data['naturalidade'];
					$est_civil = $user_data['estado_civil'];
					$email = $user_data['email'];
					$medico = $user_data['medico'];
					$idMedico = $user_data['id_medico'];
				}
			}
			else{
				header('Location: paciente.php');
			}
		}
	/* # */

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Atualizar Pacientes</title>
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
				<span class="text">Editar <span>Paciente</span>
			</div>

			<!-- Content -->
			<div id="content">

				<div class="row">
					<div class="col-6" >
						<form action="../edit/saveAttPaci.php" method="post">
							<div class="">
								<label class="form-label" for="idPaci">ID:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="idPaci" value="<?php echo $id; ?>" readonly>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="nomePaci">Nome:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="nomePaci" value="<?php echo $nome;?>">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="emailPaci">E-Mail:</label>
								<div class="input-group">
									<input required class="form-control" type="email" name="emailPaci" value="<?php echo $email;?>">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="cpfPaci">CPF:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="cpfPaci" value="<?php echo $cpf;?>" onkeypress=" return onlynumber();" maxlength="11" minlength="11">
								</div>
							</div>

							<div class="input-editar-usuarios"> <!-- solteiro(a) casado(a) uniao estavel divorciado(a) viuvo(a) -->
								<label class="form-label" for="est_civilPaci">Estado Civil:</label>
								<div class="input-group">
									<select class="form-select"  name="est_civilPaci" id="editEstCivil">
										<option <?php echo ($est_civil=='Solteiro(a)')?'selected':'';?> value="Solteiro(a)">Solteiro(a)</option>
										<option <?php echo ($est_civil=='Casado(a)')?'selected':'';?> value="Casado(a)">Casado(a)</option>
										<option <?php echo ($est_civil=='União Estável')?'selected':'';?> value="União Estável">União Estável</option>
										<option <?php echo ($est_civil=='Divorciado(a)')?'selected':'';?> value="Divorciado(a)">Divorciado(a)</option>
										<option <?php echo ($est_civil=='Viúvo(a)')?'selected':'';?> value="Viúvo(a)">Viúvo(a)</option>							
									</select>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="natuPaci">Naturalidade:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="natuPaci" value="<?php echo $naturalidade; ?>">
								</div>
							</div>


							<div class="input-editar-usuarios">
								<label class="form-label" for="generoPaci">Sexo:</label>
								<div class="input-group">
									<select class="form-select" name="generoPaci" id="editGenero">
										<option <?php echo ($genero=='Masculino')?'selected':'';?> value="Masculino">Masculino</option>
										<option <?php echo ($genero=='Feminino')?'selected':'';?> value="Feminino">Feminino</option>
										<option <?php echo ($genero=='Outro')?'selected':'';?> value="Outro">Outro</option>
									</select>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label for="nmFisioPaci" class="labelInput">Nome do Fisioterapeuta: </label>
								<select name="nmFisioPaci">
									<option>Selecione</option>
									<?php 
										$sql_nome_fisio = "select id_medico, nome from tb_medico where id_clinica = ".$idClinica;
										$result_nome_fisio = mysqli_query($conexao, $sql_nome_fisio);
										while($row_fisio = mysqli_fetch_assoc($result_nome_fisio)){ ?>
											<option <?php echo ($idMedico==$row_fisio['id_medico'])?'selected':'';?>  value="<?php echo $row_fisio['id_medico']; ?>"> <?php echo $row_fisio['nome'] ?> </option> 
									<?php }?>
								</select>
							</div>

							<div class="input-editar-usuarios date">
								<label for="dt_nascimentoPaci">Data de Nasc.:</label>
								<input required class="form-control" type="date" name="dt_nascimentoPaci" value="<?php echo $dt_nascimento; ?>">
							</div>

							<div class="agenda-botao">
								<input required class="concluir-btn" type="submit" value="Atualizar" name="atualizarPaci">
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