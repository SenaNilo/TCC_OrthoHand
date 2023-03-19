<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "bd_orthohand";


try {
    $conn = new PDO("mysql:host=$severname;
    dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}