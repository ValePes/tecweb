<?php
 include_once __DIR__.'/database.php';

 
 $data = array();
 if (isset($_POST['id'])) {
     $id = $_POST['id'];
 
     // Prepared Statement evita inyecciones SQL
     $sql = "SELECT * FROM productos WHERE id = ? AND eliminado = 0";
     if ($stmt = $conexion->prepare($sql)) {
         $stmt->bind_param("i", $id);  // Bind pasa ID como entero
         $stmt->execute();
         $result = $stmt->get_result();
 
         if ($result->num_rows > 0) {
             $rows = $result->fetch_all(MYSQLI_ASSOC);
 
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
             foreach ($rows as $num => $row) {
                 foreach ($row as $key => $value) {
                     $data[$num][$key] = utf8_encode($value);
                 }
             }
 
             echo json_encode($data, JSON_PRETTY_PRINT);  //LOS MUESTRA EN FORMATO JSON
         }
         $stmt->close();
     } else {
         echo json_encode(["status" => "error", "message" => "Error, producto no encontrado."]);
     }
 
     $conexion->close();
 } 
   
?>

