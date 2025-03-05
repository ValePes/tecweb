<?php
include_once __DIR__.'/database.php';

// OBTENER Y DECODIFICAR EL JSON RECIBIDO
$producto = file_get_contents('php://input');
if (!empty($producto)) {
    $jsonOBJ = json_decode($producto, true); // Convertir JSON a array asociativo

    // VALIDAR QUE LOS CAMPOS NECESARIOS EXISTEN
    if (!isset($jsonOBJ['nombre'], $jsonOBJ['marca'], $jsonOBJ['modelo'], $jsonOBJ['precio'], $jsonOBJ['unidades'])) {
        die(json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]));
    }

    $nombre = mysqli_real_escape_string($conexion, $jsonOBJ['nombre']);
    $marca = mysqli_real_escape_string($conexion, $jsonOBJ['marca']);
    $modelo = mysqli_real_escape_string($conexion, $jsonOBJ['modelo']);
    $precio = (float) $jsonOBJ['precio'];
    $unidades = (int) $jsonOBJ['unidades'];
    $detalles = isset($jsonOBJ['detalles']) ? mysqli_real_escape_string($conexion, $jsonOBJ['detalles']) : "";
    $imagen = isset($jsonOBJ['imagen']) ? mysqli_real_escape_string($conexion, $jsonOBJ['imagen']) : "img/default.png";

    // VERIFICAR SI EL PRODUCTO YA EXISTE
    $queryVerificar = "SELECT id FROM productos WHERE (nombre = '$nombre' AND marca = '$marca') OR (marca = '$marca' AND modelo = '$modelo') AND eliminado = 0";
    $resultVerificar = mysqli_query($conexion, $queryVerificar);

    if (mysqli_num_rows($resultVerificar) > 0) {
        die(json_encode(["status" => "error", "message" => "El producto ya existe"]));
    }

    // INSERTAR EL PRODUCTO
    $queryInsert = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagen, eliminado) 
                    VALUES ('$nombre', '$marca', '$modelo', '$precio', '$unidades', '$detalles', '$imagen', 0)";
    
    if (mysqli_query($conexion, $queryInsert)) {
        echo json_encode(["status" => "success", "message" => "Producto agregado con éxito"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar producto: " . mysqli_error($conexion)]);
    }
}
?>

