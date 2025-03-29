<?php
    use TECWEB\MYAPI\Products as Products; 
    require_once __DIR__.'/myapi/Products.php'; 
    
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $prodObj = new Products('marketzone'); 
    $prodObj->delete($id); 
    echo json_encode ($prodObj->getData()); 
?>