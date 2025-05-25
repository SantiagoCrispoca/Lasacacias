<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'db.php'; // usa conexion.php si así se llama

$productos = [
    // nombre, descripcion, imagen, precio
    ["Manojo Variado", "Manojo de liliums, elegante y sofisticado.", "imagenes/manojo-4.jpeg", 25000],
    ["Manojo Variado amarillo", "Manojo de claveles, clásico y duradero.", "imagenes/manojo-6.jpeg", 30000],
    ["Manojo Princesa", "Manojo de rosas rojas, llamativo, perfecto para las princesas de la casa.", "imagenes/manojo-7.jpg", 120000],
    ["Manojo Girasoles", "Manojo de girasoles, natural y encantador.", "imagenes/manojo-8.jpg", 40000],
    ["Ramo Rosas Rojas", "Ramo de rosas rojas en base de vidrio, perfecto para alegrar cualquier espacio.", "imagenes/ramo-2.png", 40000],
    ["Ramo Variado Rosado", "Ramo margaritas y girasoles, elegante y sofisticado.", "imagenes/ramo-3.jpg", 80000],
    ["Ramo Girasoles", "Ramo de girasoles en base de vidrio, exótico y llamativo.", "imagenes/ramo-5.jpg", 30000],
    ["Ramo Rosas Rosadas", "Ramo de rosas rosadas, ideal para bodas y eventos especiales.", "imagenes/ramo-7.jpg", 50000],
    ["Ramo Exotico", "Ramo de flores variadas, perfecto para cualquier ocasión.", "imagenes/ramo-8.jpg", 60000],
    ["Manojo de Lavanda", "Manojo natural de lavanda, fragante y relajante.", "imagenes/manojo-1.jpeg", rand(20000, 40000)],
    ["Manojo de Romero", "Manojo fresco de romero, ideal para decoración o cocina.", "imagenes/manojo-2.jpeg", rand(20000, 40000)],
    ["Manojo de Eucalipto", "Manojo de eucalipto aromático y decorativo.", "imagenes/manojo-3.jpeg", rand(20000, 40000)],
    ["Manojo de Hierbabuena", "Manojo refrescante de hierbabuena.", "imagenes/manojo-4.jpeg", rand(20000, 40000)],
    ["Manojo de Albahaca", "Manojo de albahaca, perfecto para cocina y aroma.", "imagenes/manojo-5.jpeg", rand(20000, 40000)],
    ["Manojo de Cilantro", "Manojo fresco de cilantro.", "imagenes/manojo-6.jpeg", rand(20000, 40000)],
    ["Manojo de Tomillo", "Manojo de tomillo con aroma intenso.", "imagenes/manojo-7.jpg", rand(20000, 40000)],
    ["Manojo de Menta", "Manojo de menta fresca.", "imagenes/manojo-8.jpg", rand(20000, 40000)],
    ["Ramo de Tulipanes", "Ramo de tulipanes de colores vivos.", "imagenes/ramo-2.png", rand(30000, 50000)],
    ["Ramo de Lirios", "Ramo elegante de lirios blancos y rosados.", "imagenes/ramo-3.jpg", rand(30000, 50000)],
    ["Ramo de Margaritas", "Ramo alegre de margaritas frescas.", "imagenes/ramo-5.jpg", rand(25000, 40000)],
    ["Ramo de Claveles", "Ramo clásico de claveles.", "imagenes/ramo-6.jpg", rand(25000, 45000)],
    ["Ramo de Peonias", "Ramo exuberante de peonias.", "imagenes/ramo-7.jpg", rand(40000, 60000)],
    ["Ramo de Orquídeas", "Ramo de orquídeas exóticas.", "imagenes/ramo-8.jpg", rand(40000, 60000)],
];

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO inventario (nombre, descripcion, imagen, precio, stock) VALUES (:nombre, :descripcion, :imagen, :precio, :stock)");

    foreach ($productos as $prod) {
        $stock = rand(5, 15);
        $stmt->execute([
            ':nombre' => $prod[0],
            ':descripcion' => $prod[1],
            ':imagen' => $prod[2],
            ':precio' => $prod[3],
            ':stock' => $stock
        ]);
    }

    $pdo->commit();
    echo json_encode(["success" => true, "message" => "Productos adicionales insertados correctamente."]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
