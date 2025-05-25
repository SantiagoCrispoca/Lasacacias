<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$q = $_GET['q'] ?? '';
$q = trim($q);

if (!$q) {
    echo json_encode(["success" => true, "productos" => []]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, nombre, descripcion, imagen, precio FROM inventario WHERE nombre LIKE ? OR descripcion LIKE ?");
    $like = '%' . $q . '%';
    $stmt->execute([$like, $like]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "productos" => $productos]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
