<?php
require 'db_connect.php';

// Receber o pedido_id via JSON
$data = json_decode(file_get_contents('php://input'), true);
$pedido_id = $data['pedido_id'] ?? null;

if ($pedido_id) {
    // Obter o cliente_id associado ao pedido
    $clienteIdQuery = "SELECT cliente_id FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($clienteIdQuery);
    $stmt->bind_param('i', $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();
    $cliente_id = $cliente['cliente_id'];

    if ($cliente_id) {
        // Iniciar uma transação
        $conn->begin_transaction();

        try {
            // Excluir os modelos de camisas associados ao pedido
            $deleteModelosQuery = "DELETE FROM modelos_camisas WHERE pedido_id = ?";
            $stmt = $conn->prepare($deleteModelosQuery);
            $stmt->bind_param('i', $pedido_id);
            $stmt->execute();

            // Excluir o pedido
            $deletePedidoQuery = "DELETE FROM pedidos WHERE id = ?";
            $stmt = $conn->prepare($deletePedidoQuery);
            $stmt->bind_param('i', $pedido_id);
            $stmt->execute();

            // Excluir o cliente
            $deleteClienteQuery = "DELETE FROM clientes WHERE id = ?";
            $stmt = $conn->prepare($deleteClienteQuery);
            $stmt->bind_param('i', $cliente_id);
            $stmt->execute();

            // Commit da transação
            $conn->commit();
            
            $response = ['success' => true, 'message' => 'Pedido excluído com sucesso.'];
        } catch (Exception $e) {
            // Rollback da transação em caso de erro
            $conn->rollback();
            $response = ['success' => false, 'message' => 'Erro ao excluir pedido: ' . $e->getMessage()];
        }
    } else {
        $response = ['success' => false, 'message' => 'Cliente não encontrado.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Pedido não encontrado.'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
