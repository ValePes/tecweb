<?php
    namespace TECWEB\MYAPI; 

    abstract class DataBase{
        protected $conexion; 
        protected $data = NULL;

        public function  __construct($db, $user = 'root', $pass = "Lepuchis22"){
        $this->conexion = @mysqli_connect(
            'localhost',
            $user, 
            $pass, 
            $db
        );

            if(!$this->conexion){ 
                die('¡Base de datos NO conectada!');
            }
        }

        public function getData() {
            header('Content-Type: application/json');
            if (empty($this->data)) {
                return json_encode([
                    "status" => "error",
                    "message" => "No se encontraron datos",
                    "data" => []
                ], JSON_PRETTY_PRINT);
            }
            return json_encode($this->data, JSON_PRETTY_PRINT);
        }
    }
?>