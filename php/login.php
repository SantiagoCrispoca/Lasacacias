<?php
// php/login.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: http://lasacacias.infinityfreeapp.com");
header("Content-Type: application/json");
session_start();

require __DIR__ . '/db.php'; // Asegúrate que la ruta sea correcta

$response = ["success" => false, "redirect" => "", "error" => ""];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido");
    }

    // Verificar si $pdo está definido (conexión BD)
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        throw new Exception("Error de conexión a la base de datos");
    }

    // Obtener datos
    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validaciones
    if (empty($correo)) throw new Exception("Correo requerido");
    if (empty($password)) throw new Exception("Contraseña requerida");

    // Consulta preparada
    $stmt = $pdo->prepare("SELECT ID, Nombre, Contrasena, Rol FROM usuarios WHERE Correo = ?");
    if (!$stmt->execute([$correo])) {
        throw new Exception("Error en la consulta");
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) throw new Exception("Usuario no registrado");
    if ($password !== $usuario['Contrasena']) throw new Exception("Contraseña incorrecta");

    // Sesión
    $_SESSION['user_id'] = $usuario['ID'];
    $_SESSION['user_name'] = $usuario['Nombre'];
    $_SESSION['user_role'] = $usuario['Rol'];

    $response["success"] = true;
    $response["redirect"] = ($usuario['Rol'] === 'seller') ? "vendedor.html" : "index.html";

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
    exit;
}

echo json_encode($response);
exit;
?>