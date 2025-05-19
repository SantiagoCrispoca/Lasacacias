<?php
// php/login.php
session_start();
require __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$correo   = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';

// Buscar usuario por correo
$stmt = $pdo->prepare("SELECT ID, Nombre, Contrasena, Rol FROM usuarios WHERE Correo = ?");
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && $password === $usuario['Contrasena']) {
    // Guardar datos en sesión
    $_SESSION['user_id']   = $usuario['ID'];
    $_SESSION['user_name'] = $usuario['Nombre'];
    $_SESSION['user_role'] = $usuario['Rol'];

    if ($usuario['Rol'] === 'vendedor') {
        header('Location: vendedor.html');
    } else {
        header('Location: index.html?login=user');
    }
    exit;
} else {
    header('Location: index.html?error=login');
    exit;
}