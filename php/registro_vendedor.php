<?php
// php/registro_vendedor.php
session_start();
require __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:index.html');
    exit;
}

$nombre   = trim($_POST['nombre'] ?? '');
$correo   = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$rol      = 'vendedor';

// Validaciones simples
$errors = [];
if (strlen($nombre) < 3) {
    $errors[] = 'El nombre debe tener al menos 3 caracteres.';
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'El correo no es válido.';
}
if (strlen($password) < 6) {
    $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
}

if (!empty($errors)) {
    // Pasar errores por querystring (o guarda en sesión)
    $qs = 'error=reg&msg=' . urlencode( implode(' | ', $errors) );
    header("Location:index.html?$qs");
    exit;
}

// Insertar usuario
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("
    INSERT INTO usuario (nombre, contraseña, correo, rol)
    VALUES (?, ?, ?, ?)
");
try {
    $stmt->execute([$nombre, $hash, $correo, $rol]);
    // Éxito
    header('Location: ../html/index.html?registro=ok');
    exit;
} catch (PDOException $e) {
    // Por ejemplo, correo duplicado
    header('Location: ../html/index.html?error=regdup');
    exit;
}
