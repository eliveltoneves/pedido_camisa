<?php
include 'db_connect.php';

$sql = "SELECT * FROM pedidos";
$result = $conn->query($sql);

echo "<h2>Pedidos Registrados</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Telefone</th>
<th>Email</th>
<th>Quantidade</th>
<th>Modelos</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nome']}</td>
        <td>{$row['telefone']}</td>
        <td>{$row['email']}</td>
        <td>{$row['quantidade']}</td>
        <td>{$row['modelos']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nenhum pedido encontrado</td></tr>";
}
echo "</table>";

$conn->close();
?>
