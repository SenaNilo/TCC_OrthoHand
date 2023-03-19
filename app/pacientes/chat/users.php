<?php
    session_start();
    $logged = $_SESSION['paciente'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* #Pegar nome do paciente */
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
		$sqlNm = "select pa.id_paciente, pa.nome from tb_paciente as pa join tb_usuarios as us on (us.id_usuario = pa.id_usuario) where pa.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomePaci = $row['nome'];
			$idPaci = $row['id_paciente'];
		}
		
		$primeiroNome = explode(" ", $nomePaci);
	/* # */

	/* #Pegar id do paciente e unique ID */
		$sqlID = "Select id_paciente, unique_id from tb_paciente where id_usuario =".$idUsu;
		
		$resultID = $conexao->query($sqlID);
		while($row = mysqli_fetch_array($resultID)){
			$idPaci = $row['id_paciente'];
			$_SESSION['unique_id'] = $row['unique_id'];
		}
    /* # */
    
    $unique_id = $_SESSION['unique_id'];

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
        <div id="content">
            <div class="wrapper">
                <section class="users">
                    <header>
                    <?php
                        $sql = mysqli_query($conexao, "SELECT * FROM tb_paciente WHERE unique_id = {$unique_id}");
                        if(mysqli_num_rows($sql) > 0){
                            $row = mysqli_fetch_assoc($sql);

                            if($row['img'] == null){
                                $img = "fotoperfilvazia.jpg";
                            }else{
                                $img = $row['img'];
                            }
                        }   
                    ?>
                        <div class="content">
                            <!-- Pega a imagem do usuario determinado -->
                            <img src="../../fotos/<?php echo $img ?>" alt="">
                            <!-- Detalhes do usuario -->
                            <div class="details">
                                <span><?php echo $row['nome'] ?></span>
                            </div>
                        </div>
                        <a href="#" class="logout">Perfil</a>
                    </header>
                    <div class="search">
                        <span class="text">Selecione um usuário</span>
                        <input class="input_chat" type="text" placeholder="Pesquisar por nome...">
                        <button><i class="fas fa-search"></i></button>
                    </div>

                    <div class="users-list">
                    
                    </div>
                </section>
            </div>
        </div>

    </section>

<!-- #region Scripts -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/browser.min.js"></script>
    <script src="../../assets/js/chat/users.js"></script>
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