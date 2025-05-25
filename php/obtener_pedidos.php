<?php
require 'db.php';

$correo = $_POST['correo'];
$sql = "SELECT * FROM pedidos WHERE correo = ? ORDER BY fecha DESC";


if (!$correo) {
    echo json_encode(['success' => false, 'error' => 'Correo no recibido']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM pedidos WHERE correo = ? ORDER BY fecha DESC");
    $stmt->execute([$correo]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'pedidos' => $pedidos]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
