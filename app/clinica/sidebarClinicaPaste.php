<?php 
	/* #Pegar imagem do médico */
		$sqlImg = "Select img from tb_clinica where id_usuario =".$idUsu;
			
		$resultImg = $conexao->query($sqlImg);
		while($row = mysqli_fetch_array($resultImg)){
			$ImgCli = $row['img'];
		}
		if($ImgCli != null){
			$ImgPerfil = "../../fotos/$ImgCli";
		}else{
			$ImgPerfil = "../../img/user.svg";
		}
	/* # */
?>

<!-- #sidebar -->
<div class="sidebar close">

<div class="logo-details">
    <img src="../../img/picwishOK.png">
    <span class="logo_name">OrthoHand</span>
</div>

<ul class="nav-links">

    <li>
        <div class="iocn-link">
        <a href="../indexclinic.php">
            <i class='bx bx-clinic'></i>
            <span class="link_name">Página Inicial</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="../indexclinic.php">Página Inicial</a></li>
        </ul>
        </div>
    </li>

    <li>
        <div class="iocn-link">
        <a href="#">
            <i class='bx bx-collection'></i>
            <span class="link_name">Admin.</span>
        </a>
        <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
            <li><a class="link_name" href="#">Administrar</a></li>
            <li><a href="../pacientes.php">Pacientes </a></li>
            <li><a href="../medicFisio.php">Fisioterapeutas </a></li>
        </ul>
    </li>

    <li>
        <div class="iocn-link">
        <a href="#">
            <i class='bx bx-calendar'></i>
            <span class="link_name">Agenda</span>
        </a>
        <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
            <li><a class="link_name" href="#">Agenda</a></li>
            <li><a href="../agenda/agenda.php">Marcar consultas</a></li>
            <li><a href="../visuconsultas/visuconsulta.php">Visualizar consultas</a></li>
        </ul>
    </li>

    <li>
        <a href="../dashboard.php">
            <i class='bx bx-bar-chart-alt-2'></i>
            <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="../dashboard.php">Dashboard</a></li>
        </ul>
    </li>

    <li>
        <a href="../../config/configuracoesclinica.php">
        <i class='bx bx-cog'></i>
        <span class="link_name">Configurações</span>
        </a>
        <ul class="sub-menu blank">
        <li><a class="link_name" href="../../config/configuracoesclinica.php">Configurações </a></li>
        </ul>
    </li>

       <li class="profile-details">
        <div class="div-profile-details">
            <div class="profile-content">
                <img src="<?php echo $ImgPerfil ?>"  alt="profileImg">
                <!-- <i class='bx bxs-user-circle' ></i> -->
            </div>
            <div class="name-job">
                <div class="profile_name"><?php echo $nomeCli ?></div>
                <div class="job">Clínica</div>
            </div>
            <a href="../../doLogout.php">
                <i class='bx bx-log-out'></i>
            </a>
        </div>
    </li>
</ul>

</div>
<!-- #FIM HTML SIDEBAR -->