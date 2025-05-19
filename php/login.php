login.php
<?php
// php/login.php
header("Access-Control-Allow-Origin: http://lasacacias.infinityfreeapp.com"/);
header("Content-Type: application/json");
session_start();
require DIR . '/../includes/db.php';

$response = ["success" => false, "redirect" => "", "error" => ""];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Metodo no permitido");
    }

    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar campos
    if (empty($correo)) throw new Exception("Correo requerido");
    if (empty($password)) throw new Exception("Contrasena requerida");

    // Buscar usuario
    $stmt = $pdo->prepare("SELECT ID, Nombre, Contrasena, Rol FROM usuarios WHERE Correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) throw new Exception("Usuario no registrado");
    if ($password !== $usuario['Contrasena']) throw new Exception("Contrasena incorrecta");

    // Crear sesión
    $_SESSION['user_id'] = $usuario['ID'];
    $_SESSION['user_name'] = $usuario['Nombre'];
    $_SESSION['user_role'] = $usuario['Rol'];

    $response["success"] = true;
    $response["redirect"] = ($usuario['Rol'] === 'vendedor') ? "vendedor.html" : "index.html";

} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

echo json_encode($response);
exit;
?>