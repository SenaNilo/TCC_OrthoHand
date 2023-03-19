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
		if(!empty($_GET['idFisio'])){

			$idFisio = $_GET['idFisio'];
			
			$sqlSelect = "select me.nome, me.cpf, me.crefito, me.dt_nascimento, me.genero, us.email from tb_medico as me join tb_usuarios as us on (me.id_usuario = us.id_usuario) where me.id_medico = $idFisio";

			$result = $conexao->query($sqlSelect);

			if($result->num_rows > 0){
				
				while($user_data = mysqli_fetch_assoc($result)){
					$nome = $user_data['nome'];
					$cpf = $user_data['cpf'];
					$crefito = $user_data['crefito'];
					$dt_nascimento = $user_data['dt_nascimento'];
					$genero = $user_data['genero'];
					$email = $user_data['email'];
				}
			}
			else{
				header('Location: medicFisio.php');
			}
		}
	/* # */

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Atualizar Fisioterapeutas</title>
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
				<span class="text">Editar <span>Fisioterapeuta</span>
			</div>

			<!-- Content -->
			<div id="content">

				<div class="row">
					<div class="col-6">
						<form action="../edit/saveAttFisio.php" method="post">
							<div class="">
								<label class="form-label" for="idFisio">ID:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="idFisio" value="<?php echo $idFisio; ?>" readonly>
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="nomeFisio">Nome:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="nomeFisio" value="<?php echo $nome;?>">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="emailFisio">E-Mail:</label>
								<div class="input-group">
									<input required class="form-control" type="email" name="emailFisio" value="<?php echo $email;?>">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="cpfFisio">CPF:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="cpfFisio" value="<?php echo $cpf;?>" return onlynumber();" maxlength="11" minlength="11">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="" for="crefitoFisio">Crefito:</label>
								<div class="input-group">
									<input required class="form-control" type="text" name="crefitoFisio" value="<?php echo $crefito;?>">
								</div>
							</div>

							<div class="input-editar-usuarios">
								<label class="form-label" for="generoFisio">Sexo:</label>
								<div class="input-group">
									<select class="form-select" name="generoFisio" id="editGenero">
										<option <?php echo ($genero=='Masculino')?'selected':'';?> value="Masculino">Masculino</option>
										<option <?php echo ($genero=='Feminino')?'selected':'';?> value="Feminino">Feminino</option>
										<option <?php echo ($genero=='Outro')?'selected':'';?> value="Outro">Outro</option>
									</select>
								</div>
							</div>

							<div class="input-editar-usuarios date">
								<label class="" for="dt_nascimentoFisio">Data de Nasc.:</label>
								<input required class="form-control" type="date" name="dt_nascimentoFisio" value="<?php echo $dt_nascimento; ?>">
							</div>

							<div class="agenda-botao">
								<input required class="concluir-btn" type="submit" value="Atualizar" name="atualizarFisio">
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
			<script src="../../assets/js/breakpoints.min.js"></script>
			<script src="../../assets/js/util.js"></script>
			<script src="../../assets/js/mainEdit.js"></script>
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