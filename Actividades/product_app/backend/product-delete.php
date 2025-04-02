<?php
use TECWEB\MYAPI\ProductController as ProductController; 
require_once __DIR__.'/myapi/ProductController.php';
require_once 'database.php';

// Crear una instancia del controlador
$controller = new ProductController('marketzone');

$id = isset($_GET['id']) ? $_GET['id'] : null;

// Llamar al método del controlador para eliminar el producto
if ($id) {
    $controller->deleteProduct($id);  
} else {
    echo json_encode(["status" => "error", "message" => "ID no válido"]);
}
?>