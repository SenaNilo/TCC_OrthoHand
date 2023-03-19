<?php 
// SEMPRE que trabalharmos com sesões utilizar esse session start
    session_start(); 

    $_SESSION['logged'] = False;
    $_SESSION['clinica'] = False;
    $_SESSION['paciente'] = False;
    $_SESSION['medico'] = False;

   // SE NÃO ESTIVER PREENCHIDO ESSES CAMPOS NAO VAI ENTRAR
    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        // SE A PESSOA TER O CADASTRO ACESSA
        //AQUI INCLUINDO A CONEXAO com o banco por meio da nossa pag de conexao
        include_once('conexao.php'); 
        $email = $_POST['email']; 
        $senha = $_POST['senha']; 
       
        // PEGAR E VERIFICAR SE TEM EMAIL E A SENHA NO BANCO
        $sql = "SELECT * FROM tb_usuarios WHERE email = '$email' and senha = '$senha'";

        //executando p ver se existe
        $result = $conexao->query($sql); 
        while($row = mysqli_fetch_array($result)){
          $idUsu = $row['id_usuario'];
        }

        if (mysqli_num_rows($result) < 1){
          // CASO NÃO EXISTA, ATRAVES DO UNSET DESTRUO ESSES DADOS
          unset($_SESSION['email']);
          unset($_SESSION['senha']); 
          echo "<script>window.location.href= 'login.php';alert('Login não concluído');</script>";
        }
        else{
          $_SESSION['email'] = $email;
          $_SESSION['senha'] = $senha;
          $_SESSION['logged'] = True;

          // PEGAR E VERIFICAR SE TEM EMAIL E A SENHA NO BANCO
          $sql2 = "SELECT id_tpoUsu FROM tb_usuarios WHERE id_usuario = $idUsu";
          //Executando p ver se existe
          $result2 = $conexao->query($sql2);
          while($row = mysqli_fetch_array($result2)){
            $tpoUsuValue = $row['id_tpoUsu'];
          }


          if($tpoUsuValue == 3){

            $_SESSION['clinica'] = True;
            header('Location: app/clinica/indexclinic.php');

          }elseif($tpoUsuValue == 2){
            $resultpaci = mysqli_query($conexao, "select id_paciente from tb_paciente where ativo = 'a' and id_usuario = $idUsu");
            
            if(mysqli_num_rows($resultpaci) > 0){
              $_SESSION['paciente'] = True;
              header('Location: app/pacientes/indexpaci.php');
            }else{
              echo "<script>window.location.href= 'login.php';alert('Login não concluído');</script>";
            }

          }else{
            $resultfisio = mysqli_query($conexao, "select id_medico from tb_medico where ativo = 'a' and id_usuario = $idUsu");
            
            if(mysqli_num_rows($resultfisio) > 0){
              $_SESSION['medico'] = True;
              header('Location: app/medic/indexmedic.php');
            }else{
              echo "<script>window.location.href= 'login.php';alert('Login não concluído');</script>";
            }
          }
        
       }

    }
    else{  
      header('Location: login.php'); 
      echo "<script>window.location.href= 'login.php';alert('Login não concluído');</script>";
    }


?> 