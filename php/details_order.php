<?php
require 'db_connect.php';

// Obter o ID do pedido da URL
$pedido_id = $_GET['pedido_id'];

// Consultas para obter dados do pedido
$result = $conn->query("SELECT pedidos.id, clientes.nome, clientes.telefone, clientes.email, pedidos.quantidade 
                        FROM pedidos 
                        JOIN clientes ON pedidos.cliente_id = clientes.id 
                        WHERE pedidos.id = $pedido_id");
$pedido = $result->fetch_assoc();

// Consulta para obter modelos de camisas do pedido
$modelos_result = $conn->query("SELECT modelo, tamanho FROM modelos_camisas WHERE pedido_id = $pedido_id");
$modelos = [];
while ($modelo_row = $modelos_result->fetch_assoc()) {
    $modelos[] = $modelo_row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Detalhes do Pedido <?= $pedido_id?></h1>
        <p>Nº do Pedido: <?= $pedido['id']?></p>
        <p>Nome: <?= $pedido['nome']?></p>
        <p>Telefone: <?= $pedido['telefone']?></p>
        <p>Email: <?= $pedido['email']?></p>
        <p>Quantidade de Camisas: <?= $pedido['quantidade']?></p>
        <p>Modelos de Camisas:</p>
        <ul>
            <?php foreach ($modelos as $modelo):?>
                <li><?= $modelo['modelo']?> (<?= $modelo['tamanho']?>)</li>
            <?php endforeach;?>
        </ul>
        <div class="actions">
            <button onclick="window.location.href = 'view_orders.php'">Voltar</button>
            <button onclick="window.location.href = 'update_order.php?pedido_id=<?= $pedido_id?>'">Alterar</button>
            <button onclick="excluirPedido(<?= $pedido_id?>)">Excluir</button>
        </div>
    </div>
    <script>
        function excluirPedido(pedidoId) {
            if (confirm('Você tem certeza que deseja excluir este pedido?')) {
                fetch('../php/delete_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ pedido_id: pedidoId })
                })
               .then(response => response.json())
               .then(data => {
                    if (data.success) {
                        alert('Pedido excluído com sucesso.');
                        window.location.href = 'view_orders.php';
                    } else {
                        alert('Erro ao excluir pedido: ' + data.message);
                    }
                })
               .catch(error => {
                    alert('Erro ao excluir pedido: ' + error.message);
                });
            }
        }
    </script>
</body>
</html>