*<?php
/* Conexión a MySQL */
$link = mysqli_connect("localhost", "root", "Lepuchis22", "marketzone");

// Verificar conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la base de datos. " . mysqli_connect_error());
}

// Verificar si se reciben los datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $unidades = $_POST['unidades'];
    $detalles = $_POST['detalles'];
    
    // Obtener la imagen actual de la BD en caso de que no se suba una nueva
    $query = "SELECT imagen FROM productos WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $imagen = $row['imagen']; // Guarda la imagen actual

    //si se sube una nueva imagen se actualiza la variable $imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio = "img/";
        $archivo = $directorio . basename($_FILES["imagen"]["name"]);
        // Mover el archivo subido 
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivo)) {
            $imagen = $archivo; // Actualizamos $imagen con la nueva ruta
        } else {
            echo "ERROR: No se pudo subir la imagen.";
        }
    }
    
    // Sentencia SQL para actualizar el producto
    $sql = "UPDATE productos SET 
                nombre='$nombre', 
                marca='$marca', 
                modelo='$modelo', 
                precio=$precio, 
                unidades=$unidades, 
                detalles='$detalles', 
                imagen='$imagen' 
            WHERE id=$id";
    
    if (mysqli_query($link, $sql)) {
        echo "Producto actualizado correctamente.";
    } else {
        echo "ERROR: No se pudo actualizar el producto. " . mysqli_error($link);
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar conexión
mysqli_close($link);
?>
