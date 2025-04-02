<?php
namespace TECWEB\MYAPI;
use TECWEB\MYAPI\DataBase as Database; 
require_once __DIR__ .'/DataBase.php';

class ProductModel extends Database {
    private $data = NULL; 

    // Constructor que hereda la conexión de la clase DataBase
    public function __construct($db, $user='root', $pass='jojoyrl8') {
        $this->data = array();
        parent::__construct($user, $pass, $db);  // Llama al constructor de la clase base DataBase
    }

     // Agregar producto
     public function add($prod) {
        $this->data = $prod;
        $producto = file_get_contents('php://input');
        $this->data = array(
            'status' => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );

        if (!empty($producto)) {
            $jsonOBJ = json_decode($producto);

            // Consulta para verificar si el producto ya existe
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);

            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if ($this->conexion->query($sql)) {
                    $this->data['status'] = "success";
                    $this->data['message'] = "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
            }
            $result->free();
            $this->conexion->close();
        }
    }

    // Eliminar producto
    public function delete($id) {
        $this->data = array(
            'status' => 'error',
            'message' => 'La consulta falló'
        );

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto eliminado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
    }

    public function edit($da) {
        // Verificar si se pasó un arreglo de datos
        $this->data = $da;  // Si ya se pasó un arreglo, no hace falta volver a usar $_POST o file_get_contents
    
        // Validar que los datos esenciales estén presentes
        if (!isset($this->data['id'], $this->data['nombre'], $this->data['precio'], $this->data['unidades'], $this->data['modelo'], $this->data['marca'], $this->data['detalles'], $this->data['imagen'])) {
            echo json_encode(["status" => "error", "message" => "Datos incompletos o inválidos."]);
            exit;  // Detener ejecución si los datos no son válidos
        }
    
        // Extraer datos para la consulta
        $id = $this->data['id'];
        $nombre = $this->data['nombre'];
        $precio = $this->data['precio'];
        $unidades = $this->data['unidades'];
        $modelo = $this->data['modelo'];
        $marca = $this->data['marca'];
        $detalles = $this->data['detalles'];
        $imagen = $this->data['imagen'];
    
        // Preparar la consulta SQL para actualizar el producto
        $sql = "UPDATE productos SET nombre = ?, precio = ?, unidades = ?, modelo = ?, marca = ?, detalles = ?, imagen = ? WHERE id = ?";
    
        if ($stmt = $this->conexion->prepare($sql)) {
            // Asociar los parámetros a la consulta preparada
            $stmt->bind_param('sdissssi', $nombre, $precio, $unidades, $modelo, $marca, $detalles, $imagen, $id);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    // Producto actualizado correctamente
                    echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente."]);
                } else {
                    // No se encontró un cambio en la base de datos (por ejemplo, no hubo modificación)
                    echo json_encode(["status" => "error", "message" => "No se actualizó el producto. Verifica el ID o los datos."]);
                }
            } else {
                // Error al ejecutar la consulta
                echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta: " . $stmt->error]);
            }
            $stmt->close();  // Cerrar la declaración
        } else {
            // Error al preparar la consulta
            echo json_encode(["status" => "error", "message" => "Error preparando la consulta: " . $this->conexion->error]);
        }
    
        $this->conexion->close();  // Cerrar la conexión a la base de datos
    }
    

    // Listar productos
    public function list() {
        $this->data = array();

        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    // Buscar productos por nombre
    public function search($search) {
        $this->data = array();

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    // Obtener un solo producto por ID
    public function single($id) {
        $this->data = array();

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            if ($result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}")) {
                $row = $result->fetch_assoc();
                if (!is_null($row)) {
                    foreach ($row as $key => $value) {
                        $this->data[$key] = utf8_encode($value);
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    // Devolver los datos en formato JSON
    public function getData() {
        header('Content-Type: application/json');
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

    /*/ Agregar producto
    public function add($prod) {
        $this->data = $prod;
        $producto = file_get_contents('php://input');
        $this->data = array(
            'status' => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );

        if (!empty($producto)) {
            $jsonOBJ = json_decode($producto);

            // Consulta para verificar si el producto ya existe
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);

            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if ($this->conexion->query($sql)) {
                    $this->data['status'] = "success";
                    $this->data['message'] = "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
            }
            $result->free();
            $this->conexion->close();
        }
    }

    // Eliminar producto
    public function delete($id) {
        $this->data = array(
            'status' => 'error',
            'message' => 'La consulta falló'
        );

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto eliminado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
    }

    // Editar producto
    public function edit($da) {
        $this->data = $da;
        $input = file_get_contents("php://input");
        $this->data = json_decode($input, true);

        if (!isset($this->data['id'], $this->data['nombre'], $this->data['precio'], $this->data['unidades'], $this->data['modelo'], $this->data['marca'], $this->data['detalles'], $this->data['imagen'])) {
            echo json_encode(["status" => "error", "message" => "Datos incompletos o inválidos."]);
            exit;
        }

        // Extraer datos
        $id = $this->data['id'];
        $nombre = $this->data['nombre'];
        $precio = $this->data['precio'];
        $unidades = $this->data['unidades'];
        $modelo = $this->data['modelo'];
        $marca = $this->data['marca'];
        $detalles = $this->data['detalles'];
        $imagen = $this->data['imagen'];

        $sql = "UPDATE productos SET nombre = ?, precio = ?, unidades = ?, modelo = ?, marca = ?, detalles = ?, imagen = ? WHERE id = ?";
        if ($stmt = $this->conexion->prepare($sql)) {
            $stmt->bind_param('sdissssi', $nombre, $precio, $unidades, $modelo, $marca, $detalles, $imagen, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente."]);
                } else {
                    echo json_encode(["status" => "error", "message" => "No se actualizó el producto. Verifica el ID o los datos."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparando la consulta: " . $this->conexion->error]);
        }

        $this->conexion->close();
    }

    // Listar productos
    public function list() {
        $this->data = array();

        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    // Buscar productos por nombre
    public function search($search) {
        $this->data = array();

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    // Obtener un solo producto por ID
    public function single($id) {
        $this->data = array();

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            if ($result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}")) {
                $row = $result->fetch_assoc();
                if (!is_null($row)) {
                    foreach ($row as $key => $value) {
                        $this->data[$key] = utf8_encode($value);
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    // Devolver los datos en formato JSON
    public function getData() {
        header('Content-Type: application/json');
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }*/

}
?>
