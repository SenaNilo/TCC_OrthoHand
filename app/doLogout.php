<?php
    // if(!isset($_SESSION['logado'])){
    //     session_destroy();
    //     header("Location:../../login.php");
    // }
    session_start();
    unset($_SESSION['logged']);
    unset($_SESSION['clinica']);
    unset($_SESSION['paciente']);
    unset($_SESSION['medico']);
    header('Location: ../login.php');
?>