<?php
require 'db_connect.php';

// Consultas para obter dados
$result = $conn->query("SELECT COUNT(*) AS total FROM pedidos");
$totalPedidos = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT SUM(quantidade) AS total FROM pedidos");
$totalCamisas = $result->fetch_assoc()['total'];

$modelosTotais = [];
$result = $conn->query("SELECT modelo, tamanho, COUNT(*) AS total FROM modelos_camisas GROUP BY modelo, tamanho");
while ($row = $result->fetch_assoc()) {
    $modelosTotais[] = $row;
}

$pedidos = [];
$result = $conn->query("SELECT pedidos.id AS pedido_id, clientes.nome, clientes.telefone, clientes.email, pedidos.quantidade 
                        FROM pedidos 
                        JOIN clientes ON pedidos.cliente_id = clientes.id");
while ($row = $result->fetch_assoc()) {
    $pedido_id = $row['pedido_id'];

    $modelos_result = $conn->query("SELECT modelo, tamanho FROM modelos_camisas WHERE pedido_id = $pedido_id");
    $modelos = [];
    while ($modelo_row = $modelos_result->fetch_assoc()) {
        $modelos[] = $modelo_row;
    }

    $pedidos[] = [
        'pedido_id' => $pedido_id,
        'nome' => $row['nome'],
        'telefone' => $row['telefone'],
        'email' => $row['email'],
        'quantidade' => $row['quantidade'],
        'modelos' => $modelos
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Pedidos</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script>
        function verDetalhes(pedidoId) {
            window.location.href = `details_order.php?pedido_id=${pedidoId}`;
        }

        function excluirPedido(pedidoId) {
            if (confirm('Você tem certeza que deseja excluir este pedido?')) {
                fetch('../php/delete_order.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            pedido_id: pedidoId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pedido excluído com sucesso.');
                            location.reload();
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
</head>

<body>
    <div class="container">
        <img src="../assets/img/logo_vitafit.png" alt="logo" width="300" height="300">
        <h1>Visualizar Pedidos</h1>
        <div class="stats">
            <p>Total de Pedidos: <?= $totalPedidos ?></p>
            <p>Total de Camisas: <?= $totalCamisas ?></p>
            <p>Total de Camisas por Tipo e Tamanho:</p>
            <ul>
                <?php foreach ($modelosTotais as $modelo) : ?>
                    <li><?= $modelo['modelo'] ?> (<?= $modelo['tamanho'] ?>): <?= $modelo['total'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nº Pedido</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Quantidade de Camisas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido) : ?>
                    <tr>
                        <td><?= $pedido['pedido_id'] ?></td>
                        <td><?= $pedido['nome'] ?></td>
                        <td><?= $pedido['telefone'] ?></td>
                        <td><?= $pedido['email'] ?></td>
                        <td><?= $pedido['quantidade'] ?></td>
                        <td>
                            <button onclick="verDetalhes(<?= $pedido['pedido_id'] ?>)">Detalhes</button>
                            <button onclick="window.location.href = 'update_order.php?pedido_id=<?= $pedido['pedido_id'] ?>'">Alterar</button>
                            <button onclick="excluirPedido(<?= $pedido['pedido_id'] ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>