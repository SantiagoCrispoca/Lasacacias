<?php
$host = "sql113.infinityfree.com";
$dbname = "if0_38911703_usuarios"; // Nombre correcto de la BD
$username = "if0_38911703";        // Usuario correcto
$password = "2NSoDpGB1PNq4q";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
