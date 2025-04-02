<?php
use TECWEB\MYAPI\ProductController as ProductController; 
require_once __DIR__.'/myapi/ProductController.php';
require_once 'database.php'; 

// Crear una instancia del controlador
$controller = new ProductController('marketzone');
// Obtener el ID del producto desde la solicitud POST
$productId = isset($_POST['id']) ? $_POST['id'] : null;

if ($productId) {
    $controller->viewProduct($productId);  
} else {
    echo json_encode(["status" => "error", "message" => "ID no válido"]);
}
?>