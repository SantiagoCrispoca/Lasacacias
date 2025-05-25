<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT id, nombre, stock FROM inventario ORDER BY nombre ASC");
    $flores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "flores" => $flores]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
