<?php
    namespace TECWEB\MYAPI\CREATE; 
    use TECWEB\MYAPI\DataBase as Database; 

    class Create extends DataBase{

        public function __construct($db){ 
            $this->data = array(); 
            parent::__construct($db); 
        }

        public function add($prod) {
            $this->data= $prod;
            $producto = file_get_contents('php://input');
            $this->data = array(
                'status' => 'error',
                'message' => 'El nombre del producto ya existe, por favor ingresa otro nombre'
            );
            
            if(!empty($producto)) {
                $jsonOBJ = json_decode($producto);
                
                // Verificar si json_decode fue exitoso
                if(json_last_error() !== JSON_ERROR_NONE) {
                    $this->data['message'] = 'JSON inválido';
                    return;
                }
                
                // Validar que el objeto tenga las propiedades necesarias
                if(!isset($jsonOBJ->nombre)) {
                    $this->data['message'] = 'El campo nombre es requerido';
                    return;
                }
                
                // Escapar valores para prevenir SQL injection
                $nombre = $this->conexion->real_escape_string($jsonOBJ->nombre);
                $marca = $this->conexion->real_escape_string($jsonOBJ->marca ?? '');
                $modelo = $this->conexion->real_escape_string($jsonOBJ->modelo ?? '');
                $precio = floatval($jsonOBJ->precio ?? 0);
                $detalles = $this->conexion->real_escape_string($jsonOBJ->detalles ?? '');
                $unidades = intval($jsonOBJ->unidades ?? 1);
                $imagen = $this->conexion->real_escape_string($jsonOBJ->imagen ?? 'img/imagen.png');
        
                // Verificar si el producto ya existe
                $sql = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0 LIMIT 1";
                $result = $this->conexion->query($sql);
                
                if ($result->num_rows == 0) {
                    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                            VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";
                    
                    if($this->conexion->query($sql)){
                        $this->data['status'] = "success";
                        $this->data['message'] = "Producto agregado";
                        $this->data['id'] = $this->conexion->insert_id;
                    } else {
                        $this->data['message'] = "ERROR: " . $this->conexion->error;
                    }
                    $result->free();
                }
            }
        }

    }
?>