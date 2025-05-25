<?php
require 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM pedidos WHERE estado = 'pendiente' ORDER BY fecha DESC");
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'pedidos' => $pedidos]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
