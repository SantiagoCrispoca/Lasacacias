<?php
// php/agregar_producto.php
session_start();
require __DIR__ . '/../includes/db.php';

// Solo vendedores pueden agregar
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'vendedor') {
    header('Location:index.html?error=auth');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:vendedor.html');
    exit;
}

// Campos del formulario
$titulo      = trim($_POST['titulo'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio      = floatval($_POST['precio']  ?? 0);
$stock       = intval($_POST['stock']      ?? 0);

// Validaciones básicas
$errors = [];
if ($titulo === '') {
    $errors[] = 'El título es obligatorio.';
}
if ($descripcion === '') {
    $errors[] = 'La descripción es obligatoria.';
}
if ($precio <= 0) {
    $errors[] = 'El precio debe ser mayor a 0.';
}
if ($stock < 0) {
    $errors[] = 'El stock no puede ser negativo.';
}

// Procesar imagen
$imagenNombre = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $tmp  = $_FILES['imagen']['tmp_name'];
    $ext  = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $imagenNombre = uniqid('prod_') . '.' . $ext;
    $dest = __DIR__ . '/../uploads/' . $imagenNombre;
    if (!move_uploaded_file($tmp, $dest)) {
        $errors[] = 'Error al guardar la imagen.';
    }
} else {
    $errors[] = 'La imagen es obligatoria.';
}

if (!empty($errors)) {
    $_SESSION['prod_errors'] = $errors;
    header('Location:vendedor.html');
    exit;
}

// Insertar en BD
$stmt = $pdo->prepare("
    INSERT INTO producto (titulo, descripcion, precio, stock, imagen)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$titulo, $descripcion, $precio, $stock, $imagenNombre]);

header('Location:vendedor.html?producto=ok');
exit;
