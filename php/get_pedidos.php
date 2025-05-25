<?php
// php/get_pedidos.php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$stmt = $pdo->query("SELECT id, correo, items, total, fecha 
                     FROM pedidos 
                     WHERE estado='pendiente' 
                     ORDER BY fecha DESC");
$ped = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($ped as &$p) {
    $p['items'] = json_decode($p['items'], true);
}

echo json_encode(['success'=>true,'pedidos'=>$ped]);
