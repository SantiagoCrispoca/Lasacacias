<?php

header("Access-Control-Allow-Origin: https://lasacacias.infinityfreeapp.com");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

ini_set('display_errors',1);
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

$productos = json_decode($items, true);
if (!is_array($productos)) {
    echo json_encode(["success" => false, "error" => "Formato de productos inválido"]);
    exit;
}

// Validar stock disponible para cada producto
foreach ($productos as $producto) {
    $nombre = $producto['nombre'];
    $cantidad = intval($producto['cantidad']);

    $stmt = $pdo->prepare("SELECT stock FROM inventario WHERE nombre = ?");
    $stmt->execute([$nombre]);
    $stockActual = $stmt->fetchColumn();

    if ($stockActual === false) {
        echo json_encode(["success" => false, "error" => "Producto '$nombre' no encontrado en inventario"]);
        exit;
    }

    if ($cantidad > $stockActual) {
        echo json_encode(["success" => false, "error" => "No hay suficiente stock de '$nombre'. Disponible: $stockActual"]);
        exit;
    }
}

// Registrar el pedido
try {
    $stmt = $pdo->prepare("INSERT INTO pedidos (correo, items, total) VALUES (?, ?, ?)");
    $stmt->execute([$correo, $items, $total]);
    $idPedido = $pdo->lastInsertId();

    // Descontar del inventario
    foreach ($productos as $producto) {
        $nombre = $producto['nombre'];
        $cantidad = intval($producto['cantidad']);

        $stmt = $pdo->prepare("UPDATE inventario SET stock = stock - ? WHERE nombre = ?");
        $stmt->execute([$cantidad, $nombre]);
    }

    echo json_encode(["success" => true, "id" => $idPedido]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
