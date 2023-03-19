<?php 
	session_start();
	$logged = $_SESSION['clinica'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	//destruir a sessao
	if(isset($_GET['logout']) && $_GET['logout'] == 1){
		$_SESSION = array();
		session_destroy();
		header('Location: ../../login.php');
	}

	/* Validacao do CPF */
		class ValidarCPF{
			function validaCPF($cpf) {
		
				// Extrai somente os números
				$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
				
				// Verifica se foi informado todos os digitos corretamente
				if (strlen($cpf) != 11) {
					return false;
				}
		
				// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
				if (preg_match('/(\d)\1{10}/', $cpf)) {
					return false;
				}
		
				// Faz o calculo para validar o CPF
				for ($t = 9; $t < 11; $t++) {
					for ($d = 0, $c = 0; $c < $t; $c++) {
						$d += $cpf[$c] * (($t + 1) - $c);
					}
					$d = ((10 * $d) % 11) % 10;
					if ($cpf[$c] != $d) {
						return false;
					}
				}
				return true;
			}
		}
	/* * */

	/* Funcao para o CPF do usuario */
		function cpf($cpf){
			return substr($cpf, 0, 3).".".substr($cpf, 3, 3).".".substr($cpf, 6,-2)."-".substr($cpf, -2);
		}
	/* * */

	//Conexão com o banco
	include_once("../../conexao.php");
	
	/* #Pegar o nome da clinica */
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
	$idClinica = $_SESSION['id_clinica'];
	/* # */

	/* #region CONSULTA */
		$txt_pesquisa = (isset($_POST["txt_pesquisa"]))?$_POST["txt_pesquisa"]:"";

		$consulta = "select me.id_medico, me.nome, us.email, me.cpf, me.crefito, me.dt_nascimento, me.genero from tb_medico as me join tb_usuarios as us on (me.id_usuario = us.id_usuario) WHERE me.id_clinica = '$idClinica' and me.ativo = 'a' and (me.nome LIKE '{$txt_pesquisa}%' or me.cpf LIKE '{$txt_pesquisa}%' or me.crefito LIKE '{$txt_pesquisa}%') ";

		$con = $conexao->query($consulta) or die ($conexao->error);
	/* # */

	/* #Cadastro dos Fisioterapeutas */
		// Se tiver submit vai enviar pro meu banco de dados
		if(isset($_POST['submit']))
		{
		// incluir a conexao 
			include_once('../../conexao.php');
			
			
			$val = new ValidarCPF();
			$cpf = $_POST['cpf'];

			if($val -> ValidaCPF($cpf) == true){
				$nome = $_POST['nome']; 
				$crefito = $_POST['crefito'];
				$dt_nascimento = $_POST['dt_nascimento']; 
				$genero = $_POST['genero']; 
				$email = $_POST['email'];
				$senha = $_POST['senha']; 
				
				//Validação para ver se o campo está ou nao vazio
				if(!empty($nome) || !empty($cpf) || !empty($crefito) || !empty($dt_nascimento) || !empty($genero) || !empty($email) || !empty($senha)){
					//AGORA O INSERT no banco -- Id_TpoUsu = 1 por conta que ele eh um fisioterapeuta
					// $sqlDelFisio = "call spDelFisio('$idFisio')";
					// $result = $conexao->query($sqlDelFisio);
					$sqlCadFisio = "Call spCadFisio('$idClinica', '$nome', '$cpf', '$crefito', '$dt_nascimento', '$genero', '$email', '$senha')";

					$resultCad = $conexao->query($sqlCadFisio);


					header("Refresh:0");
				}
			}else{
				echo "<script> alert('CPF inválido!'); </script>";
			}
		}
	/* # */
?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="icon" href="../../img/logoicon.png">
		<title>Gerenciamento de Fisioterapeutas</title>
		<meta charset="utf-8" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">
		
		<!-- #sidebar -->
		<?php include('sidebarClinica.php'); ?>


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
				<span class="text">Tabela dos <span>Fisioterapeutas</span>
			</div>

			<div id="content">

				<div class="table-title">
					<button id="btn-modal" class="btn-cad">Cadastrar fisioterapeuta</button>
				</div>
				
				<form action="medicFisio.php" method="post"> 
					<div class="search_wrap search_wrap_1">
						<div class="search_box">
							<input type="text" class="input" name="txt_pesquisa" placeholder="Pesquise pelo nome, cpf ou crefito...">

							<div class="btn btn_common">
								<img src="../img/magnifying-glass-solid.svg">
							</div>
						</div>
					</div>
				</form>

				<!-- #region JANELA MODAL JS -->
					<div id="modal" class="modal-container">
						<div class="modal">
							<button id="fecharX" class="fechar">x</button>
				
							<form id="form" method="POST">
								<div class="input-group">
									<div class="input-box">
										<label for="nome" class="labelInput">Nome: </label>
										<input type="text" name="nome" id="nome" class="inputUser" placeholder="Digite o nome do médico" required>
									</div>
				
									<div class="input-box">
										<label for="cpf" class="labelInput">CPF: </label>
										<input type="text" name="cpf" id="cpf" class="inputUser" placeholder="Digite o cpf" onkeypress="return onlynumber();" maxlength="11" minlength="11" required>
									</div>
				
									<div class="input-box">
										<label for="crefito" class="labelInput">Crefito médico: </label>
										<input type="text" name="crefito" id="crefito" class="inputUser" placeholder="Digite o crefito" onkeypress="return onlynumber();" maxlength="6" minlength="6" required>
									</div>
				
									<div class="input-box data">
										<label for="dt_nascimento" class="labelInput">Data do nascimento: </label>
										<input type="date" name="dt_nascimento" id="dt_nascimento" class="inputUser" required>
									</div>
				
									<div class="input-box">
										<label for="genero">Gênero: </label>
										<input type="radio" id="masc" name="genero" value="Masculino" checked>
										<label for="Masculino">Masculino</label>
				
										<input type="radio" id="femi" name="genero" value="Feminino">
										<label for="Feminino" checked>Feminino</label>
				
										<input type="radio" id="outro" name="genero" value="Outro">
										<label for="Outro">Outro</label>
									</div>
				
									<div class="input-box">
										<label for="email" class="labelInput">E-mail: </label>
										<input type="text" name="email" id="email" class="inputUser" placeholder="Digite o email" required>
									</div>
				
									<div class="input-box">
										<label for="senha" class="labelInput">Senha: </label>
										<input type="password" name="senha" id="senha" class="inputUser" placeholder="Digite a senha do médico" required>
									</div>
				
									<hr class="modalHr">
				
									<div class="continue-button">
										<input type="submit" name="submit" value="Cadastrar" class="btn-cadastrar" id="submit">
									</div>
								</div>
							</form>
						</div>
					</div>
				<!-- #endregion -->

				<!-- #region Table -->
					<table id="keywords" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
							<th>Clínicos</th>
							<th>E-mail</th>
							<th>CPF</th>
							<th>Crefito</th>
							<th>Dt de Nascimento</th>
							<th>Gênero</th>
							<th>Alterar Dados</th>
							</tr>
						</thead>
						<tbody>
						<?php while($dado = $con->fetch_array()) { ?>
							<tr>
							<td class="lalign"><?php echo $dado["nome"]; ?></td>
							<td><?php echo $dado["email"];?></td>
							<td><?php echo cpf($dado["cpf"]);?></td>
							<td><?php echo $dado["crefito"];?></td>
							<td><?php echo date("d/m/Y", strtotime($dado["dt_nascimento"]));?></td>
							<td><?php echo $dado["genero"];?></td>
							<td>
								<a href="atualizar/editarFisio.php?idFisio=<?php echo $dado['id_medico']?>"><button>Alterar</button></a>
								<a href="deletar/deletarFisio.php?idFisio=<?php echo $dado['id_medico']?>"><button class="btn-del">Deletar</button></a>
							</td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				<!-- #endregion -->

			</div>
		</section>
			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>
			<script src="../assets/js/modal.js"></script>
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