<?php
    // update for categories
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
  
    //create database object
    $database = new Database();
    $db = $database->connect();
  
    // create category object
    $cat = new Category($db);

    // get data
    $data = json_decode(file_get_contents("php://input"));

    //check if the data needed exists.. if not quit
    if (!isset($data->id) || !isset($data->category)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
    }

    $cat->category = $data->category;
    $cat->id = $data->id;

    // update category
    if ($cat->update()){
        echo json_encode(array('id'=>$cat->id,'category'=>$cat->category));
    }
    //if not found message
    else
    {
        echo json_encode(array('message' => 'category_id Not Found'));
    }
