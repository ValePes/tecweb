<?php
    use TECWEB\MYAPI\Products as Products; 
    require_once __DIR__.'/myapi/Products.php'; 
    
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $prodObj = new Products('marketzone'); 
    $prodObj->delete($id); 
    echo json_encode ($prodObj->getData()); 
?>