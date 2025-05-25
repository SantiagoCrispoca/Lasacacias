<?php
// php/login.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: http://lasacacias.infinityfreeapp.com");
header("Content-Type: application/json"); // Asegurar cabecera JSON
session_start();

require __DIR__ . '/db.php';

$response = ["success" => false, "redirect" => "index.html", "error" => "", "role" => ""];

try {

    session_regenerate_id(true); //  Previene sesiones estáticas
    $_SESSION = array(); //  Limpia datos antiguos

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido");
    }

    if (!isset($pdo) || !($pdo instanceof PDO)) {
        throw new Exception("Error de conexión a la base de datos");
    }

    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($correo)) throw new Exception("Correo requerido");
    if (empty($password)) throw new Exception("Contraseña requerida");

    $stmt = $pdo->prepare("SELECT ID, Nombre, Contrasena, Rol FROM usuarios WHERE Correo = ?");
    if (!$stmt->execute([$correo])) {
        throw new Exception("Error en la consulta");
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) throw new Exception("Usuario no registrado");
    if ($password !== $usuario['Contrasena']) throw new Exception("Contraseña incorrecta");

    $_SESSION['user_id'] = $usuario['ID'];
    $_SESSION['user_name'] = $usuario['Nombre'];
    $_SESSION['user_role'] = $usuario['Rol'];

    $response["success"] = true;
    $response["role"] = $usuario['Rol'];
    $response["correo"] = $correo;

} catch (Exception $e) {
    http_response_code(500);
    $response["error"] = $e->getMessage();
}

// Forzar salida JSON
die(json_encode($response));
?>