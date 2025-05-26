<?php
header("Content-Type: application/json");
require __DIR__ . '/db.php';

$query = $_GET['q'] ?? '';

if (!$query) {
    echo json_encode(['success' => false, 'error' => 'Falta el parámetro de búsqueda']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM inventario WHERE nombre LIKE ? OR descripcion LIKE ? LIMIT 10");
    $like = "%$query%";
    $stmt->execute([$like, $like]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'productos' => $productos]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
