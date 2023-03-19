<?php
    session_start();    
    $unique_id = $_SESSION['unique_id'];

    include_once "../../../../conexao.php";
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = mysqli_real_escape_string($conexao, $_POST['searchTerm']);
    $output = "";

    $sql = mysqli_query($conexao, "SELECT pa.* FROM tb_paciente as pa join tb_medico as me on (me.id_medico = pa.id_medico) where me.unique_id = $unique_id and pa.ativo = 'a' and pa.nome LIKE '%{$searchTerm}%'");
    if(mysqli_num_rows($sql) > 0){ //Aqui é para pesquisar os nomes dos usuarios, se não bater o usuario com a pesquisa, ele vai mostrar que não foi nada encontrado
        include "data.php";
    }else{
        $output .= "Nenhum usuario encontrado para sua pesquisa"; 
    }
    echo $output;
?>