<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'db.php'; // o 'conexion.php' si usas otro nombre

// Lista de productos
$productos = [
    ["Ramo Rosas Rojas", "Un hermoso ramo de rosas rojas, perfecto para cualquier ocasión.", "imagenes/ramo-1.jpeg", 80000],
    ["Manojo Variado", "Manojo de Rosas variadas, ideal para expresar amor y pureza.", "imagenes/manojo-2.jpeg", 30000],
    ["Ramo Girasoles y Rosas", "Ramo de girasoles y rosas rojas, lleno de energía y frescura.", "imagenes/ramo-4.jpg", 70000],
    ["Manojo Variado rosado", "Manojo de margaritas, fresco y juvenil.", "imagenes/manojo-5.jpeg", 25000],
    ["Ramo Variado", "Ramo de girasoles y flores silvestres, natural y encantador.", "imagenes/ramo-6.jpg", 80000],
    ["Manojo De Girasoles", "Manojo de girasoles, lleno de energía y alegría.", "imagenes/manojo-3.jpeg", 40000],
    ["Jarron de rosas rojas", "Ramo de tulipanes, perfecto para alegrar cualquier espacio.", "imagenes/ramo-2.png", 22000],
    ["Ramo variado", "Ramo de liliums, elegante y sofisticado.", "imagenes/ramo-3.jpg", 24000],
    ["Ramo de girasoles y rosas", "Ramo de girasoles y margaritas, lleno de energía y frescura.", "imagenes/ramo-4.jpg", 21000],
    ["Ramo de rosas variadas", "Un ramo con una mezcla de rosas para ocasiones especiales.", "imagenes/Ramo9.jpeg", 75000],
    ["Ramo de girasoles", "Ramo vibrante con girasoles frescos.", "imagenes/Ramo10.jpeg", 65000],
    ["Manojo variado", "Manojo de flores variadas, ideal para decoración.", "imagenes/Manojo10.jpeg", 55000],
    ["Manojo variado clásico", "Manojo de flores clásicas para un toque elegante.", "imagenes/Manojo11.jpeg", 60000]
];

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO inventario (nombre, descripcion, imagen, precio, stock) VALUES (:nombre, :descripcion, :imagen, :precio, :stock)");

    foreach ($productos as $prod) {
        $stock = rand(5, 15); // Stock aleatorio
        $stmt->execute([
            ":nombre" => $prod[0],
            ":descripcion" => $prod[1],
            ":imagen" => $prod[2],
            ":precio" => $prod[3],
            ":stock" => $stock
        ]);
    }

    $pdo->commit();
    echo json_encode(["success" => true, "message" => "Inventario inicial insertado correctamente."]);

} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
