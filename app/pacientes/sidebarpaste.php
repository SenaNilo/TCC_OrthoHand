<?php 
	/* #Pegar imagem do médico */
		$sqlImg = "Select img from tb_paciente where id_usuario =".$idUsu;
			
		$resultImg = $conexao->query($sqlImg);
		while($row = mysqli_fetch_array($resultImg)){
			$ImgPaci = $row['img'];
		}
		if($ImgPaci != null){
			$ImgPerfil = "../../fotos/$ImgPaci";
		}else{
			$ImgPerfil = "../../img/user.svg";
		}
	/* # */
?>

<div class="sidebar close">

			<div class="logo-details">
				<img src="../../img/picwishOK.png">
				<span class="logo_name">OrthoHand</span>
			</div>

			<ul class="nav-links">

				<li>
					<div class="iocn-link">
					<a href="../indexpaci.php">
						<!-- <i class='bx bx-clinic'></i> -->
						<i class='bx bx-male'></i>
						<span class="link_name">Monitoramento</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name" href="../indexpaci.php">Monitoramento</a></li>
					</ul>
					</div>
				</li>

				<li>
					<div class="iocn-link">
					<a href="../visuconsultaPaci.php">
						<i class='bx bx-calendar'></i>
						<span class="link_name">Agenda</span>
					</a>
					<!-- <i class='bx bxs-chevron-down arrow'></i> -->
					</div>
					<ul class="sub-menu blank">
						<li><a class="link_name" href="../visuconsultaPaci.php">Agenda</a></li>
						<!-- <li><a href="../visuconsultaPaci.php">Visualizar consultas</a></li> -->
					</ul>
				</li>

				<li>
					<a href="../chat/users.php">
						<i class='bx bx-chat'></i>
						<span class="link_name">Chat</span>
					</a>
					<ul class="sub-menu blank">
						<li><a class="link_name" href="../chat/users.php">Chat</a></li>
					</ul>
				</li>

				<li>
					<a href="../../config/configuracoespaciente.php">
					<i class='bx bx-cog'></i>
					<span class="link_name">Configurações</span>
					</a>
					<ul class="sub-menu blank">
					<li><a class="link_name" href="../../config/configuracoespaciente.php">Configurações </a></li>
					</ul>
				</li>

				<li class="profile-details">
					<div class="div-profile-details">
						<div class="profile-content">
							<img src="<?php echo $ImgPerfil  ?>" alt="profileImg">
						</div>
						<div class="name-job">
							<div class="profile_name"><?php echo $nomePaci ?></div>
							<div class="job">Paciente</div>
						</div>
						<a href="../../doLogout.php">
							<i class='bx bx-log-out'></i>
						</a>
					</div>
				</li>
			</ul>

		</div>