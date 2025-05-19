<?php
// php/login.php
session_start();
require __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:index.html');
    exit;
}

$correo   = $_POST['correo']   ?? '';
$password = $_POST['password'] ?? '';

// Buscar usuario por correo
$stmt = $pdo->prepare("SELECT id, nombre, contraseña, rol FROM usuario WHERE correo = ?");
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($password, $usuario['contraseña'])) {
    // Guardar datos en sesión
    $_SESSION['user_id']   = $usuario['id'];
    $_SESSION['user_name'] = $usuario['nombre'];
    $_SESSION['user_role'] = $usuario['rol'];

    // Solo vendedores pueden entrar al panel
    if ($usuario['rol'] === 'vendedor') {
        header('Location:vendedor.html');
        exit;
    } else {
        // Si quieres redirigir a otro dashboard para usuarios normales...
        header('Location:index.html?login=user');
        exit;
    }
} else {
    header('Location:index.html?error=login');
    exit;
}