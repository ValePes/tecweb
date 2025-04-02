<?php

use TECWEB\MYAPI\ProductController as ProductController; 
require_once __DIR__ . '/myapi/ProductController.php';
require_once 'database.php'; 

$controller = new ProductController('marketzone');

$productData = json_decode(file_get_contents('php://input'), true);

$controller->addProduct($productData); 

?>