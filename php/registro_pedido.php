<?php

header("Access-Control-Allow-Origin: lasacacias.infinityfreeapp.com"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$correo = $_POST['correo'] ?? null;
$items = $_POST['items'] ?? null;
$total = $_POST['total'] ?? null;

if (!$correo || !$items || !$total) {
    echo json_encode(["success" => false, "error" => "Faltan datos del pedido"]);
    exit;
}

try {
    $pdo->beginTransaction();

    // Insertar pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (correo, items, total) VALUES (?, ?, ?)");
    $stmt->execute([$correo, $items, $total]);
    $pedidoId = $pdo->lastInsertId();

    // Restar stock por cada producto del pedido
    $productos = json_decode($items, true);
    if (!is_array($productos)) throw new Exception("Error al decodificar los productos del carrito.");

    foreach ($productos as $producto) {
        $nombre = $producto['nombre'] ?? null;
        $cantidad = intval($producto['cantidad'] ?? 0);

        if ($nombre && $cantidad > 0) {
            $stmt = $pdo->prepare("UPDATE inventario SET stock = stock - ? WHERE nombre = ? AND stock >= ?");
            $stmt->execute([$cantidad, $nombre, $cantidad]);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'id' => $pedidoId
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
