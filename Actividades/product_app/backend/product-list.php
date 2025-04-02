<?php

use TECWEB\MYAPI\ProductController as ProductController; 
require_once __DIR__.'/myapi/ProductController.php';
require_once 'database.php'; // Conexión a la base de datos

// Crear una instancia del controlador
$controller = new ProductController('marketzone');
$controller->showProductList(); 
?>