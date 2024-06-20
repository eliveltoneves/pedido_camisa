<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pedido_camisas";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if(!$conn) {
    die("Conexão falhou. Erro: " .mysqli_connect_error());
}
?>
