<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

require_once 'db.php'; // o 'conexion.php'

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

if ($id <= 0 || $cantidad <= 0) {
    echo json_encode(["success" => false, "error" => "Datos inválidos"]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE inventario SET stock = stock + :cantidad WHERE id = :id");
    $stmt->execute([
        ":cantidad" => $cantidad,
        ":id" => $id
    ]);
    echo json_encode(["success" => true, "message" => "Stock actualizado correctamente"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
