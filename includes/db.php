<?php
$host = "sql113.infinityfree.com"; // Reemplaza por tu host real
$dbname = "if0_38911703_XXX";
$username = "if0_38911703_XXX";
$password = "2NSoDpGB1PNq4q";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión exitosa!";
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}
?>
