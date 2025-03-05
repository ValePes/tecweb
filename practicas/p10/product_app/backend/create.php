<?php
include_once _DIR_ . '/database.php';

// Obtener la información del producto enviada por el cliente
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    // Convertir JSON a objeto PHP
    $jsonOBJ = json_decode($producto);

    // Validar que se recibieron los datos necesarios
    if (!isset($jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->unidades)) {
        echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
        exit;
    }

    // Prevenir inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
    $marca = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
    $modelo = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
    $precio = (float) $jsonOBJ->precio;
    $unidades = (int) $jsonOBJ->unidades;
    $detalles = isset($jsonOBJ->detalles) ? mysqli_real_escape_string($conexion, $jsonOBJ->detalles) : "N/A";
    $imagen = isset($jsonOBJ->imagen) ? mysqli_real_escape_string($conexion, $jsonOBJ->imagen) : "img/default.png";

    // Verificar si el producto ya existe con "eliminado = 0"
    $sql_check = "SELECT id FROM productos 
                  WHERE ((nombre = '$nombre' AND marca = '$marca') 
                  OR (marca = '$marca' AND modelo = '$modelo')) 
                  AND eliminado = 0";

    $result = $conexion->query($sql_check);

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "El producto ya existe en la base de datos"]);
    } else {
        // Insertar el producto si no existe
        $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagen, eliminado)
                       VALUES ('$nombre', '$marca', '$modelo', $precio, $unidades, '$detalles', '$imagen', 0)";

        if ($conexion->query($sql_insert)) {
            echo json_encode(["status" => "success", "message" => "Producto agregado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al agregar el producto: " . $conexion->error]);
        }
    }

    $conexion->close();
}
?>
