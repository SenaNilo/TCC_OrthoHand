<?php
    session_start();
	$logged = $_SESSION['paciente'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

    /* Funcao para o CPF do usuario */
		function cpf($cpf){
			return substr($cpf, 0, 3).".".substr($cpf, 3, 3).".".substr($cpf, 6,-2)."-".substr($cpf, -2);
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
		
		//Pegar todos os dados do paciente
		$sqlNm = "select pa.id_paciente, pa.nome, pa.cpf, pa.dt_nascimento, pa.genero, pa.naturalidade, pa.estado_civil from tb_paciente as pa join tb_usuarios as us on (us.id_usuario = pa.id_usuario) where pa.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomePaci = $row['nome'];
			$idPaci = $row['id_paciente'];
            $cpf = $row['cpf'];
            $dt_nascimento = $row['dt_nascimento'];
            $genero = $row['genero'];
            $naturalidade = $row['naturalidade'];
            $estado_civil = $row['estado_civil'];
		}
	/* # */

    /* #Pegar imagem do Paci */
		$sqlImg = "Select img from tb_paciente where id_usuario =".$idUsu;
			
		$resultImg = $conexao->query($sqlImg);
		while($row = mysqli_fetch_array($resultImg)){
			$ImgPaci = $row['img'];
		}
		if($ImgPaci != null){
			$perfilFoto = "../fotos/$ImgPaci";
		}else{
			$perfilFoto = "perfil.png";
		}
	/* # */

    /* #Alterar foto */
        if(isset($_POST['atualizarFT'])){
            if(isset($_FILES['file'])){
                
                $arquivo = $_FILES['file'];
                
                if($arquivo['error']){
                    die("Falha ao enviar o arquivo, ou nenhuma foto foi inserida");
                }

                $nomeDoArquivo = $arquivo['name'];
                $nomeDoNovoArquivo = uniqid();
                $pasta = "../fotos/";
                $nomeDaFoto = $nomeDoNovoArquivo . $nomeDoArquivo;

                $deu_certo = move_uploaded_file($arquivo['tmp_name'],  $pasta . $nomeDaFoto);

                if($deu_certo){
                    $resultImg = mysqli_query($conexao, "update tb_paciente set img = '$nomeDaFoto' where id_paciente = $idPaci");
                    echo "<script> alert('Imagem inserida com sucesso!!') </script>";
                    header("Refresh:0");
                }else{
                    echo "<p> Falha ao enviar o arquivo </p>";
                }
            }
        }
    /* # */

    /* #Alterar Senha */
        if(isset($_POST['atualizarSenha'])){
            $atualP = $_POST['atualpassword'];
            $novaP = $_POST['novapassword'];
            $confirmP = $_POST['password'];

            if(($atualP == $senha) && ($novaP == $confirmP)){
                $resultNewSenha = mysqli_query($conexao, "update tb_usuarios set senha = '$novaP' where id_usuario = $idUsu");
                $_SESSION['senha'] = $novaP;
                echo "<script> alert('Senha alterada com sucesso!!') </script>";
                header("Refresh:0");
                
            }else{
                echo "<script> alert('Senha não alterada, verifique os campos'); </script>";
            }
        }
    /* # */
?>

<!DOCTYPE html>
<html lang="Pt-BR">
<head>
    <meta charset='utf-8'>
    <link rel="icon" href="../../img/logoicon.png">
       <!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Configurações</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="../assets/css/config.css" />
    
</head>
<body>

    <a href="javascript:history.back();">
        <button class="cta">
            Voltar <i class="ri-arrow-right-line"></i>
        </button>
    </a>

    <div class="container">
        <div class="leftbox">
            <nav>
                <a onclick="tabs(0)" class="tab">
                    <img src="../img/perfil.png" class="imgconfig">
                    <i class="fa fa-user"></i>
                </a>
                <a onclick="tabs(1)" class="tab">
                    <img src="../img/bubble-chat.png" class="imgconfig">
                    <i class="fa fa-credit-card"></i>
                </a>
                <a onclick="tabs(2)" class="tab">
                    <img src="../img/visualizar.png" class="imgconfig">
                    <i class="fa fa-tv"></i>
                </a>
               
            </nav>
        </div>
        <div class="rightbox">            
            <div class="profile tabShow">

                <h1>Alterar Imagem</h1>

                <form method="post" enctype="multipart/form-data" action="">
                    <div class="profile-pic-div" id="divImg">
                        <img src="<?php echo $perfilFoto ?>" id="photo">
                        <input type="file" name="file" id="file">
                        <label for="file" id="uploadBtn" accept=".jpg, .png, .jpeg" multiple>Alterar Foto</label>
                    </div> 
                    <input class="btnAlterar" type="submit" value="Mudar Foto" name="atualizarFT"> 
                </form>

                <h1>Mudar Senha</h1>

                <form method="POST">

                    <div class="passwd-wrap">
                    <h2>Senha atual</h2>
                    <input type="password" class="input" id="atualpassword" name="atualpassword" placeholder="Senha atual">
                    <button type="button" class="pass" id="show-passwd">
                        <i class='bx bx-low-vision'></i>
                    </button>

                    <h2>Nova Senha</h2>
                    <input type="password" class="input" id="novapassword" name="novapassword" placeholder="Nova senha">
                    <button type="button" class="pass" id="show-passwddois">
                        <i class='bx bx-low-vision'></i>
                    </button>

                    <h2>Repita a nova senha</h2>
                    <input type="password" class="input" id="password" name="password" placeholder="Confirme sua nova senha">
                    <button type="button" class="pass" id="show-passwdtres">
                        <i class='bx bx-low-vision'></i>
                    </button>

                    </div> 
                    <input class="btnAlterar" type="submit" value="alterar" name="atualizarSenha"> 
                </form>
            </div> 

            <div class="payment tabShow">
                <h1>Contate-nos</h1>
                <form
      action="https://formsubmit.co/OrthoHandDev@gmail.com"
      method="POST"
      class="form">
                <h2>Nome</h2>
                <input type="text" class="input" name="name" id="name" value="<?php echo $nomePaci ?>" required />
                <h2>E-mail</h2>
                <input type="email" class="input" name="email" id="email" required placeholder="exemplo@gmail.com" />
                <h2>Envie sua Mensagem</h2>
                
                 <!--   <textarea id="message" placeholder="Digite sua mensagem" name="message"></textarea> -->  
                    
                    <textarea placeholder="Sua mensagem..." name="message" id="message" required></textarea>
                    <i class="material-icons"></i>
                    <input type="hidden" name="_captcha" value="false" />
                    <input type="hidden" name="_next" value="http://localhost/TCC_OFC/app/config/obrigado.php"/> 

                    <button class="btnSolicitar" type="submit" href="../config/obrigado.html">Solicitar</button>                
            </div>

            <div class="subscription tabShow">
                <h1>Visualizar Perfil</h1>
                <h2>Nome</h2>
                <p><?php echo $nomePaci ?></p>

                <h2>Cpf</h2>
                <p><?php echo cpf($cpf) ?></p>

                <h2>Data de Nascimento</h2>
                <input type="date" class="input" value="<?php echo $dt_nascimento ?>" readonly>

                <h2>Gênero</h2>
                <p><?php echo $genero ?></p>

                <h2>Naturalidade</h2>
                <p><?php echo $naturalidade ?></p>

                <h2>Estado Civil</h2>
                <p><?php echo $estado_civil ?></p>
            </div>

        </div>
    </div>
    <script>
    </script>
    <script>
        const tabBtn = document.querySelectorAll(".tab");
        const tab = document.querySelectorAll(".tabShow");
        function tabs(panelIndex) {
            tab.forEach(function(node) {
                node.style.display = "none";
            });
            tab[panelIndex].style.display = "block";
            }
            tabs(0);
        
    </script>
    <script>
        $(".tab").click(function() {
            $(this).addClass("active").siblings().removeClass("active");
        })
    </script>
      <script src="../assets/js/fotoconfig.js"></script>
     <script src='../assets/js/mostrarsenha.js'></script>
</body>
</html>
