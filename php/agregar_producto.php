<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

// Validación de campos
$nombre = $_POST['nombre'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

if (!$nombre || !$descripcion || $precio <= 0 || $stock < 0 || !isset($_FILES['imagen'])) {
    echo json_encode(["success" => false, "error" => "Campos inválidos o incompletos"]);
    exit;
}

// Procesar imagen
$imagenTmp = $_FILES['imagen']['tmp_name'];
$imagenNombre = uniqid('img_') . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
$rutaFinal = 'imagenes/' . $imagenNombre;
$destino = __DIR__ . '/../imagenes/' . $imagenNombre;

if (!move_uploaded_file($imagenTmp, $destino)) {
    echo json_encode(["success" => false, "error" => "No se pudo guardar la imagen"]);
    exit;
}

// Insertar en la tabla inventario
try {
    $stmt = $pdo->prepare("INSERT INTO inventario (nombre, descripcion, imagen, precio, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $rutaFinal, $precio, $stock]);
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
