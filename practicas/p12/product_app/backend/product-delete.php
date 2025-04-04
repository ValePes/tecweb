<?php
     require_once __DIR__ . '/vendor/autoload.php'; 

     use TECWEB\MYAPI\DELETE\Delete as Delete; 
    
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $prodObj = new Delete('marketzone'); 
    $prodObj->delete($id);
    
    echo json_encode ($prodObj->getData()); 
?>