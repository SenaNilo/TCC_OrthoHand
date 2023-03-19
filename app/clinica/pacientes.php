<?php 
	session_start();
	$logged = $_SESSION['clinica'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

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

	//inclusão com a conexão
	include('../../conexao.php');

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

	/* #Consulta */  //Pesquisa 
		$txt_pesquisa = (isset($_POST["txt_pesquisa"]))?$_POST["txt_pesquisa"]:"";
	  	//trazendo as informações e a pesquisa     
			$sql = "select pa.id_paciente, pa.nome, us.email, pa.cpf, pa.dt_nascimento, pa.genero, pa.naturalidade, me.nome as fisioterapeuta  from tb_paciente as pa join tb_usuarios as us on (us.id_usuario = pa.id_usuario)	join tb_medico as me on (me.id_medico = pa.id_medico) join tb_clinica as cl on (cl.id_clinica = me.id_clinica) where cl.id_clinica = ".$idClinica." and pa.ativo = 'a' and (pa.nome LIKE '{$txt_pesquisa}%' or pa.nome LIKE '{$txt_pesquisa}%' or pa.cpf LIKE '{$txt_pesquisa}%')";

			
			$rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta" . mysqli_error($conexao));
	/* # */

	/* Cadastrar Pacientes */
		// Se tiver submit vai enviar pro meu banco de dados
		if(isset($_POST['submit'])){
			// incluir a conexao 
			include_once('../../conexao.php');
			
			$val = new ValidarCPF();
			$cpf = $_POST['cpf'];

			if($val -> ValidaCPF($cpf) == true){
				$nome = $_POST['nome'];
				$dt_nascimento = $_POST['dt_nascimento']; 
				$genero = $_POST['genero'];
				$naturalidade = $_POST['local'];
				$est_civil = $_POST['est_civil'];
				$email = $_POST['email'];
				$senha = $_POST['senha'];
				$nmfisio = $_POST['nmfisio']; 

				//Validação para ver se o campo está ou nao vazio
				if(empty($nome) || empty($cpf) || empty($dt_nascimento) || empty($genero) || empty($naturalidade) || empty($est_civil) || empty($email) || empty($senha) || empty($nmfisio)){
				}
				else{
					//Pegar o id do medico
					

					//AGORA O INSERT no banco -- Id_TpoUsu = 2 por conta que ele eh o paciente
					$result = mysqli_query($conexao, "insert into tb_usuarios (email, senha, id_tpoUsu) values ('$email', '$senha', 2)");

					$id_usuario = mysqli_insert_id($conexao);

					$result2 = mysqli_query($conexao, "insert into tb_paciente (nome, cpf, dt_nascimento, genero, naturalidade, estado_civil, ativo, id_usuario, id_medico) Values ('$nome', '$cpf', '$dt_nascimento', '$genero', '$naturalidade', '$est_civil', 'a', '$id_usuario', '$nmfisio')");

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
		<title>Gerenciamento de Pacientes</title>
		<meta charset="utf-8" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">
	
		<!-- #sidebar -->
		<?php include('sidebarClinica.php'); ?>

		<!-- Content -->
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
				<span class="text">Tabela de <span>Pacientes</span>
    		</div>

			<div id="content">

				<div class="table-title">
					<button id="btn-modal" class="btn-cad">Cadastrar Pacientes</button>
				</div>
		
		
			
				<form action="pacientes.php" method="post"> 
					<div class="search_wrap search_wrap_1">
						<div class="search_box">
							<input type="text" class="input" name="txt_pesquisa" placeholder="Pesquise pelo nome ou cpf...">
							
							<div class="btn">
								<input class="" type="submit" value="">
								<img src="../img/magnifying-glass-solid.svg">
							</div>
						</div>
					</div>	
				</form>

		
					

    

				<?php
				// Validacao do cadastro
					include_once('../../cadastrar.php');

					if(isset($_POST['submit']))
					{
						$nome = $_POST['nome']; 
						$genero = $_POST['genero']; 
						$cpf = $_POST['cpf']; 
						$dtnascimento = $_POST['dt_nascimento']; 
						$naturalidade = $_POST['local'];
						$estcivil = $_POST['est_civil']; 
						$email = $_POST['email']; 
						$nmfisio = $_POST['nmfisio']; 
						

						$paciente = new CadastroPaciente($nome, $genero, $cpf, $dtnascimento, $email, $naturalidade, $estcivil, $nmfisio);
						echo $paciente->criarObj($paciente);
					}
				?>
				<!-- #region Modal paci -->
				<div id="modal" class="modal-container">
					<div class="modal">
						<button id="fecharX" class="fechar">x</button>
			
						<form id="form" method="POST">
							<div class="input-group">
								<div class="input-box">
									<label for="nome" class="labelInput">Nome: </label>
									<input type="text" name="nome" id="nome" class="inputUser" placeholder="Digite o nome do paciente" required>
								</div>
			
								<div class="input-box">
									<label for="genero">Gênero: </label>
									
									<input type="radio" id="masc" name="genero" value="Masculino">
									<label for="masculino">Masculino</label>
			
									<input type="radio" id="femi" name="genero" value="Feminino" checked>
									<label for="feminino">Feminino</label>
			
									<input type="radio" id="outro" name="genero" value="Outro">
									<label for="outro">Outro</label>
								</div>					

								<div class="input-box">
									<label for="cpf" class="labelInput">CPF: </label>
									<input type="text" name="cpf" id="cpf" class="inputUser" placeholder="Digite o cpf" onkeypress="return onlynumber();" maxlength="11" minlength="11" required>
								</div>
			
								<div class="input-box data">
									<label for="dt_nascimento" class="labelInput">Data do nascimento: </label>
									<input type="date" name="dt_nascimento" id="dt_nascimento" class="inputUser" required>
								</div>

								<div class="input-box">
									<label for="local" class="labelInput">Local de Nascimento (Cidade e estado): </label>
									<input type="text" name="local" id="local" class="inputUser" placeholder="Digite o local" required>
								</div>

								<div class="input-box">
									<label for="est_civil">Estado Civil:</label>
									<select id="est_civil" name="est_civil">
										<option readonly>Selecione</option>
										<option value="Solteiro(a)">Solteiro(a)</option>
										<option value="Casado(a)">Casado(a)</option>
										<option value="Uniao Estavel">União Estável</option>
										<option value="Divorciado(a)">Divorciado(a)</option>
										<option value="Viúvo(a)">Viúvo(a)</option>
									</select>
								</div>
			
								<div class="input-box">
									<label for="email" class="labelInput">E-mail: </label>
									<input type="text" name="email" id="email" class="inputUser" placeholder="Digite o email" required>
								</div>
			
								<div class="input-box">
									<label for="senha" class="labelInput">Senha: </label>
									<input type="password" name="senha" id="senha" class="inputUser" placeholder="Digite a senha do paciente" required>
								</div>
			

								<div class="input-box">
									<label for="nmfisio" class="labelInput">Nome do Fisioterapeuta: </label>
									<select name="nmfisio">
										<option>Selecione</option>
										<?php 
											$sql_nome_fisio = "select id_medico, nome from tb_medico where id_clinica = ".$idClinica." and ativo = 'a'";
											$result_nome_fisio = mysqli_query($conexao, $sql_nome_fisio);
											while($row_fisio = mysqli_fetch_assoc($result_nome_fisio)){ ?>
												<option value="<?php echo $row_fisio['id_medico']; ?>"> <?php echo $row_fisio['nome'] ?> </option> 
										<?php }?>
									</select>
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

				<!-- #region Tabela -->
					<table id="keywords" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
							<th>Pacientes</th>
							<th>E-mail</th>
							<th>CPF</th>
							<th>Dt Nascimento</th>
							<th>Gênero</th>
							<th>Naturalidade</th>
							<th>Fisioterapeuta</th>

							<th>Alterar Dados</th>
							</tr>
						</thead>
						<tbody>
						<?php while($dado = mysqli_fetch_assoc($rs)){ ?>
							<tr>
								<td class="lalign"><?php echo $dado["nome"];?></td>

								<td><?php echo $dado["email"];?></td>

								<td><?php echo cpf($dado["cpf"]); ?></td>

								<td><?php echo date("d/m/Y", strtotime($dado["dt_nascimento"]));?></td>

								<td><?php echo $dado["genero"];?></td>

								<td><?php echo $dado["naturalidade"];?></td>

								<td><?php echo $dado["fisioterapeuta"];?></td>
								

								<td>
									<a href='atualizar/editarPaciente.php?id=<?php echo $dado['id_paciente']?>'><button>Alterar</button></a>
									<a href='deletar/deletarPaci.php?id=<?php echo $dado['id_paciente']?>'><button class="btn-del">Deletar</button></a>
								</td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				<!-- #endregion -->
			</div>
			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
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