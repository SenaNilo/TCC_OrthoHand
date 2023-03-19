<?php
  session_start();
	$loggedPa = $_SESSION['paciente'] ?? NULL;
  $loggedMe = $_SESSION['medico'] ?? NULL;
  $loggedCl = $_SESSION['clinica'] ?? NULL;
	if(!$loggedPa && !$loggedMe && !$loggedCl) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="../../img/logoicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/config.css" />
    <title>Obrigado por nos contatar</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
  <a href="javascript:history.back();">
        <button class="cta">
            Voltar <i class="ri-arrow-right-line"></i>
        </button>
    </a>

    <div class="containerThx">
    <center> 
      <br>
    <h1 class="letter">Obrigado por nos contatar.</h1><br>
  </center>
  <div class="faq-img">
      <img src="undraw_appreciate_it_qnkk.svg" alt="" class="thanks-img">
  </div>
  </div>
  
  </body>
</html>