<?php
session_start();
$logged = $_SESSION['clinica'] ?? NULL;
if(!$logged) die ('Sessão Encerrada!');

$email = $_SESSION['email'];
$senha = $_SESSION['senha'];
// print_r($email);

include_once('../../../conexao.php');
/* #Pegar nome da Clinica */
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

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Agendamento</title>
        <meta charset='utf-8'/>
        <link rel="icon" href="../../../img/logoicon.png">
        <!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <link href='../../assets/css/core/main.min.css' rel='stylesheet' />
        <link href='../../assets/css/daygrid/main.min.css' rel='stylesheet' />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <link rel="stylesheet" href="../../assets/css/agenda.css">

        <script src='../../assets/js/core/main.min.js'></script>
        <script src='../../assets/js/interaction/main.min.js'></script>
        <script src='../../assets/js/daygrid/main.min.js'></script>
        <script src='../../assets/js/core/locales/pt-br.js'></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script src="../../assets/js/agenda.js"></script>
    </head>
    <body>

        <!-- #sidebar -->
		<?php include('../sidebarClinicaPaste.php'); ?>
        
        <!-- Content -->
		<section class="home-section">
	
			<div class="home-content">
				<i class='bx bx-menu'></i>
				<span class="text">Agenda</span>
    		</div>
			
			<div id="content">
                <div id='calendar'></div>
            </div>

        </section>
        

        <!-- #region JANELA MODAL CAD -->
            <div id="modal" class="modal-container">
                <div class="modal-calendar">
                    <button id="fecharX" data-dismiss="modal" class="fechar">x</button>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Consulta</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <span id="msg-cad"></span>
                        <form id="addevent" method="POST" action="cad_event.php"> <!--enctype="multipart/form-data"-->
                            <div class="form-group row">
                                <label class="labelInput" for="title">Título</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Titulo" required>
                            </div>

                            <div class="form-group row">
                                <label class="labelInput" for="paciente">Paciente</label>
                                <select class="select-agenda" name="paciente" id="paciente" required>
                                    <option>Selecione</option>
                                    <?php 
                                        $sql_nome_paci = "select pa.id_paciente, pa.nome from tb_paciente as pa join tb_medico as me on (me.id_medico = pa.id_medico) where me.id_clinica = ".$idClinica." and pa.ativo = 'a' and me.ativo = 'a' order by pa.nome";
                                        $result_nome_paci = mysqli_query($conexao, $sql_nome_paci);
                                        while($row_paci = mysqli_fetch_assoc($result_nome_paci)){ ?>
                                            <option value="<?php echo $row_paci['id_paciente']; ?>"> <?php echo $row_paci['nome'] ?> </option> 
                                    <?php }?>
                                </select>
                            </div>

                            <div class="form-group row">
                                <label class="labelInput" for="nmfisio">Fisioterapeuta</label>
                                <select class="select-agenda" name="nmfisio" id="nmfisio" readonly required>
                                    <option>Selecione o fisioterapeuta</option>
                                </select>
                            </div>

                            <div class="form-group row">
                                <label class="labelInput">Início da consulta</label>
                                <input type="text" name="start" class="form-control" id="start" onkeypress="DataHora(event, this)" required>
                            </div>

                            <div class="form-group row">
                                <label class="labelInput">Final da consulta</label>
                                <input type="text" name="end" class="form-control" id="end"  onkeypress="DataHora(event, this)" required>
                            </div>

                            <div class="form-group row">
                                <div class="cadastrar-modal">
                                    <button type="submit" name="CadEvent" id="CadEvent" class="btn btn-cad-agenda">Cadastrar</button>                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- #endregion -->

        <!-- #region JANELA MODAL VISU -->
            <div id="visualizar" class="modal-container">
                <div class="modal-calendar-visu">
                    <button id="fecharX" data-dismiss="modal" class="fechar">x</button>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalhes da Consulta</h5>
                    </div>
                    <div class="modal-body">
                        <div class="visevent">
                            <dl class="row">
                                <!-- <dt class="col-sm-3">ID do evento</dt>
                                <dd class="col-sm-9" id="id"></dd> -->

                                <dt class="col-sm-3">Título: </dt>
                                <dd class="col-sm-9" id="title"></dd>

                                <dt class="col-sm-3">Início da consulta: </dt>
                                <dd class="col-sm-9" id="start"></dd>

                                <dt class="col-sm-3">Fim da consulta: </dt>
                                <dd class="col-sm-9" id="end"></dd>

                                <dt class="col-sm-3">Paciente: </dt>
                                <dd class="col-sm-9" id="paci"></dd>

                                <dt class="col-sm-3">Fisioterapeuta: </dt>
                                <dd class="col-sm-9" id="fisio"></dd>
                            </dl>
                            <button class="btn btn-edit btn-canc-vis">Editar</button>
                            <a href="" id="apagar_evento" class="btn btn-delete">Apagar</a>
                        </div>
                        <div class="formedit">
                            <span id="msg-edit"></span>
                            <form id="editevent" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" >
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Título</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Título do evento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Início do evento</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="start" class="form-control" id="start" onkeypress="DataHora(event, this)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Final do evento</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="end" class="form-control" id="end"  onkeypress="DataHora(event, this)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Paciente</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="paciEdit" id="paciEdit" required>
                                            <option>Selecione</option>
                                            <?php 
                                                $sql_nome_paci = "select pa.id_paciente, pa.nome from tb_paciente as pa join tb_medico as me on (me.id_medico = pa.id_medico) where me.id_clinica = ".$idClinica." and pa.ativo = 'a' and me.ativo = 'a' order by pa.nome";
                                                $result_nome_paci = mysqli_query($conexao, $sql_nome_paci);
                                                while($row_paci = mysqli_fetch_assoc($result_nome_paci)){ ?>
                                                    <option value="<?php echo $row_paci['id_paciente']; ?>"> <?php echo $row_paci['nome'] ?> </option> 
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Fisioterapeuta</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="fisioEdit" id="fisioEdit" readonly required>
                                            <option>Selecione o fisioterapeuta</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="button" class="btn btn-edit btn-canc-edit">Cancelar</button>
                                        <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-save">Salvar</button>                                    
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->


<!-- #region SCRIPT -->
    <script src="../../assets/js/subselect.js"></script>
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
