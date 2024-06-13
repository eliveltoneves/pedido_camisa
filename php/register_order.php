<?php
require 'db_connect.php';

// Iniciar sessão
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $quantidade = $_POST['quantidade'];
    $modelos = $_POST['modelo'];
    $tamanhos = $_POST['tamanho'];

    // Inserir cliente
    $stmt = $conn->prepare("INSERT INTO clientes (nome, telefone, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $telefone, $email);
    $stmt->execute();
    $cliente_id = $stmt->insert_id;
    $stmt->close();

    // Inserir pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, quantidade) VALUES (?, ?)");
    $stmt->bind_param("ii", $cliente_id, $quantidade);
    $stmt->execute();
    $pedido_id = $stmt->insert_id;
    $stmt->close();

    // Inserir modelos de camisas
    for ($i = 0; $i < count($modelos); $i++) {
        $modelo = $modelos[$i];
        $tamanho = $tamanhos[$i];
        $stmt = $conn->prepare("INSERT INTO modelos_camisas (pedido_id, modelo, tamanho) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $pedido_id, $modelo, $tamanho);
        $stmt->execute();
    }

    echo "Pedido inserido com sucesso!";
} else {
    echo "Método de requisição inválido.";
}

$conn->close();
?>
