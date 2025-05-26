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

// Registrar el pedido sin validar stock todavía
try {
    $stmt = $pdo->prepare("INSERT INTO pedidos (correo, items, total) VALUES (?, ?, ?)");
    $stmt->execute([$correo, $items, $total]);
    $idPedido = $pdo->lastInsertId();

    echo json_encode(["success" => true, "id" => $idPedido]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
