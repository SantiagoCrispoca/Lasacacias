<?php

header("Access-Control-Allow-Origin: lasacacias.infinityfreeapp.com"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// php/registro_pedido.php
ini_set('display_errors',1);
error_reporting(E_ALL);

require __DIR__ . '/db.php'; // tu conexión de antes

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'error'=>'Método no permitido']);
    exit;
}

$correo = $_POST['correo'] ?? null;
$items = $_POST['items'] ?? null;
$total = $_POST['total'] ?? null;

if (!$correo || !$items || !$total) {
    echo json_encode(["success" => false, "error" => "Faltan datos del pedido"]);
    exit;
}


// 2) Insertar
try {
    $stmt = $pdo->prepare("
        INSERT INTO pedidos (correo, items, total) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$correo, $items, $total]);
    echo json_encode([
      'success'=>true, 
      'id'=>$pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
