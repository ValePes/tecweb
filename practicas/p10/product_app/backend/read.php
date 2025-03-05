<?php
    include_once __DIR__.'/database.php';
/*
    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_POST['id']) ) {
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'") ) {
            // SE OBTIENEN LOS RESULTADOS
			$row = $result->fetch_array(MYSQLI_ASSOC);

            if(!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($row as $key => $value) {
                    $data[$key] = $value; // utf8_encode($value);
                }
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
*/


// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array();
// SE VERIFICA SI SE RECIBIÓ UN TEXTO DE BÚSQUEDA
if (isset($_POST['query'])) {
    $query = $_POST['query'];   
    // SE PREPARA LA CONSULTA PARA BUSCAR EN NOMBRE, MARCA Y DETALLES
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$query%' OR marca LIKE '%$query%' OR detalles LIKE '%$query%'";

    if ($result = $conexion->query($sql)) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row; // Agrega cada producto encontrado al array
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();
}

// DEVUELVE LOS RESULTADOS EN FORMATO JSON
echo json_encode($data, JSON_PRETTY_PRINT);

?>