<?php
    include_once __DIR__ . '/database.php';

    // Capturar los datos JSON enviados desde el frontend
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!isset($data['id'], $data['nombre'], $data['precio'], $data['unidades'], $data['modelo'], $data['marca'], $data['detalles'], $data['imagen'])) {
        echo json_encode(["status" => "error", "message" => "Datos incompletos o inválidos."]);
        exit;
    }

    // Extraer datos del array
    $id = $data['id'];
    $nombre = $data['nombre'];
    $precio = $data['precio'];
    $unidades = $data['unidades'];
    $modelo = $data['modelo'];
    $marca = $data['marca'];
    $detalles = $data['detalles'];
    $imagen = $data['imagen'];

    // Validaciones básicas
    if (empty($nombre) || strlen($nombre) > 100) {
        echo json_encode(["status" => "error", "message" => "El nombre es obligatorio y debe tener menos de 100 caracteres."]);
        exit;
    }
    if (!is_numeric($precio) || $precio <= 0) {
        echo json_encode(["status" => "error", "message" => "El precio debe ser un número mayor a 99.99"]);
        exit;
    }
    if (!is_numeric($unidades) || $unidades < 1) {
        echo json_encode(["status" => "error", "message" => "Las unidades deben ser mayor o igual a 1."]);
        exit;
    }

    // Actualiza el producto
    $sql = "UPDATE productos SET nombre = ?, precio = ?, unidades = ?, modelo = ?, marca = ?, detalles = ?, imagen = ? WHERE id = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('sdissssi', $nombre, $precio, $unidades, $modelo, $marca, $detalles, $imagen, $id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "La actualizacion de los datos fallo, verifique los datos."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "La consulta fallo, por favor vuelve a intentarlo " . $stmt->error]);
        }
        $stmt->close();
    } 

    $conexion->close();
?>

