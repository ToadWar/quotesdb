<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
  
  
    $database = new Database();
    $db = $database->connect();
  
    $cat = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $cat->category = $data->category;
    $cat->id = $data->id;

    if ($cat->update()){
        echo json_encode(array('message' => 'Category updated'));
    }
    else
    {
        echo json_encode(array('message' => 'category_id Not Found'));
    }
