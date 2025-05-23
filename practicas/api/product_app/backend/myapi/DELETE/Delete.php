<?php

    namespace TECWEB\MYAPI\DELETE;
    use TECWEB\MYAPI\DataBase as Database; 

    class Delete extends DataBase{
        public function __construct($db){ 
            $this->data = array(); 
            parent::__construct($db); 
        }

        public function delete ($id){
            // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
           $this->data = array(
               'status'  => 'error',
               'message' => 'No se pudo eliminar el producto'
           );
           
               // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
               $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
               if ($this->conexion->query($sql) ) {
                   $this->data['status'] = "success";
                   $this->data['message'] = "Producto eliminado";
               } else {
                   $this->$data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
               }
               
               $this->conexion->close();    
       }

    }

?>