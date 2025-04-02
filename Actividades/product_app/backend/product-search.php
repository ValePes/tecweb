<?php
use TECWEB\MYAPI\ProductController as ProductController; 
require_once __DIR__.'/myapi/ProductController.php';
require_once 'database.php'; 

// Crear una instancia del controlador
$controller = new ProductController('marketzone');
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

if ($searchTerm) {
    $controller->searchProduct($searchTerm);  
} else {
    echo json_encode(["status" => "error", "message" => "Término de búsqueda no válido"]);
}
?>
