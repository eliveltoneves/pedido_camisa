<?php
require 'db_connect.php';

$modelosDisponiveis = ["Modelo 1", "Modelo 2", "Modelo 3"]; // Modelos predefinidos
$tamanhosDisponiveis = ["P", "M", "G", "GG"]; // Tamanhos predefinidos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar o pedido no banco de dados
    $pedido_id = $_POST['pedido_id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $quantidade = $_POST['quantidade'];
    $modelos = $_POST['modelos']; // Assumindo que `modelos` é um array com os modelos e tamanhos

    // Atualizar as informações do cliente
    $stmt = $conn->prepare("UPDATE clientes SET nome=?, telefone=?, email=? WHERE id=(SELECT cliente_id FROM pedidos WHERE id=?)");
    $stmt->bind_param("sssi", $nome, $telefone, $email, $pedido_id);
    $stmt->execute();
    $stmt->close();

    // Atualizar a quantidade do pedido
    $stmt = $conn->prepare("UPDATE pedidos SET quantidade=? WHERE id=?");
    $stmt->bind_param("ii", $quantidade, $pedido_id);
    $stmt->execute();
    $stmt->close();

    // Atualizar os modelos de camisas
    $stmt = $conn->prepare("DELETE FROM modelos_camisas WHERE pedido_id=?");
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $stmt->close();

    foreach ($modelos as $modelo) {
        $stmt = $conn->prepare("INSERT INTO modelos_camisas (pedido_id, modelo, tamanho) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $pedido_id, $modelo['modelo'], $modelo['tamanho']);
        $stmt->execute();
        $stmt->close();
    }

    // Redirecionar de volta para a página de visualização de pedidos
    header('Location: view_orders.php');
    exit;
} else {
    // Obter os detalhes do pedido do banco de dados
    $pedido_id = $_GET['pedido_id'];
    $result = $conn->query("SELECT pedidos.id AS pedido_id, clientes.nome, clientes.telefone, clientes.email, pedidos.quantidade 
                            FROM pedidos 
                            JOIN clientes ON pedidos.cliente_id = clientes.id 
                            WHERE pedidos.id = $pedido_id");
    $pedido = $result->fetch_assoc();

    // Obter os modelos de camisas do pedido
    $modelos_result = $conn->query("SELECT modelo, tamanho FROM modelos_camisas WHERE pedido_id = $pedido_id");
    $modelos = [];
    while ($row = $modelos_result->fetch_assoc()) {
        $modelos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pedido</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/script.js" defer></script> <!-- Referência ao script.js -->
</head>
<body>
    <div class="container">
        <h1>Alterar Pedido #<?php echo $pedido['pedido_id']; ?></h1>
        <form action="update_order.php" method="POST">
            <input type="hidden" name="pedido_id" value="<?php echo $pedido['pedido_id']; ?>">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $pedido['nome']; ?>" required>
            </div>
            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $pedido['telefone']; ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $pedido['email']; ?>" required>
            </div>
            <div>
                <label for="quantidade">Quantidade de Camisas:</label>
                <input type="number" id="quantidade" name="quantidade" value="<?php echo $pedido['quantidade']; ?>" required>
            </div>
            <div id="camisas-container">
                <!-- Campos dinâmicos de modelos e tamanhos aparecerão aqui -->
            </div>
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
