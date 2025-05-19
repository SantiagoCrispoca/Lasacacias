<?php
// includes/db.php

// Datos de conexión
$host = 'sql113.infinityfree.com';
$db   = 'if0_38911703_XXX';
$user = 'if0_38911703';
$pass = '2NSoDpGB1PNq4q';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8";

try {
    // Conexión con PDO y configuración de errores/excepciones
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Si falla, mostramos mensaje y detenemos la ejecución
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
