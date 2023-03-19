<?php
    session_start();
    $logged = $_SESSION['medico'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* #Pegar nome do medico */
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
		$sqlNm = "select me.nome from tb_medico as me join tb_usuarios as us on (us.id_usuario = me.id_usuario) where me.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomeFisio = $row['nome'];
		}

		$primeiroNome = explode(" ", $nomeFisio);

	/* # */

	/* #Pegar id do médico e unique ID */
		$sqlID = "Select id_medico, unique_id from tb_medico where id_usuario =".$idUsu;
		
		$resultID = $conexao->query($sqlID);
		while($row = mysqli_fetch_array($resultID)){
			$idMedic = $row['id_medico'];
			$_SESSION['unique_id'] = $row['unique_id'];
		}
    /* # */
    
    $unique_id = $_SESSION['unique_id'];
    /* #Validacao do uniqueId */
        $val = null;
        $unique_Paci = $_GET['id_usuario'];
        $sqlValId = mysqli_query($conexao, "select pa.unique_id as chavePaci, me.unique_id from tb_paciente as pa join tb_medico as me on (me.id_medico = pa.id_medico) where me.unique_id = ".$unique_id." and pa.unique_id = ".$unique_Paci);
        if(mysqli_num_rows($sqlValId) > 0){
            $val = true;
        }else{
            session_destroy();
            header('Location: ../../../index.html');
        }
    /* # */
    

?>


<?php include_once "header.php";?>

<body>

    <?php include('../sidebarpaste.php') ?>

    <section class="home-section">

        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Ortho<span>Chat</span></span>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="wrapper">
            <section class="chat-area">
                <header>
                <?php
                    $id_usuario = mysqli_real_escape_string($conexao, $_GET['id_usuario']);
                    $sql = mysqli_query($conexao, "SELECT nome, img FROM tb_paciente WHERE unique_id = {$id_usuario}");
                    if(mysqli_num_rows($sql) > 0){
                        $row = mysqli_fetch_assoc($sql);
                        
                        if($row['img'] == null){
                            $img = "fotoperfilvazia.jpg";
                        }else{
                            $img = $row['img'];
                        }
                    }
                ?>
                    <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                    <img src="../../fotos/<?php echo $img ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['nome']?></span>
                    </div>
                </header>
                <div class="chat-box">
                
                    
                
                </div>
                <form id="form-chat" class="typing-area" autocomplete = "off">
                    <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                    
                    <input type="text" name="incoming_id" value="<?php echo $id_usuario;?>" hidden>
                    
                    <input type="text" name="message" class="input-field" placeholder="Digite uma nova mensagem...">
                    
                    <button><i class="fab fa-telegram-plane"></i></button>
                </form>
            </section>
            </div>
        </div>
    </section>


    <!-- Scripts -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/browser.min.js"></script>
    <script src = "../../assets/js/chat/chat.js"></script>
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