<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
  
  
    $database = new Database();
    $db = $database->connect();
  
    $cat = new Category($db);

    $cat->id = isset($_GET['id']) ? $_GET['id']: die();

    if ($cat->delete()){
        echo json_encode(array('message' => 'Category id '.$cat->id.' deleted'));
    }
    else
    {
        echo json_encode(array('message' => 'No Categories found'));
    }