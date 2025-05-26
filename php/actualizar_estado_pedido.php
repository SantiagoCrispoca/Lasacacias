<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

require_once 'db.php'; // si así se llama tu conexión

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$estado = isset($_POST['estado']) ? $_POST['estado'] : null;

if ($id <= 0 || !$estado) {
    echo json_encode(["success" => false, "error" => "Datos incompletos"]);
    exit;
}

try {
    // 1. Actualizar estado del pedido
    $stmt = $pdo->prepare("UPDATE pedidos SET estado = :estado WHERE id = :id");
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // 2. Si el estado es "entregado", restar stock
    if ($estado === 'entregado') {
        $stmt = $pdo->prepare("SELECT items FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pedido && $pedido['items']) {
            $productos = json_decode($pedido['items'], true);

            if (is_array($productos)) {
                foreach ($productos as $producto) {
                    $nombre = $producto['nombre'];
                    $cantidad = intval($producto['cantidad']);

                    $stmt = $pdo->prepare("UPDATE inventario SET stock = stock - ? WHERE nombre = ?");
                    $stmt->execute([$cantidad, $nombre]);
                }
            }
        }
    }
    
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Error al actualizar: " . $e->getMessage()]);
}
?>
