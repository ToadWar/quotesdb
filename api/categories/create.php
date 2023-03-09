<?php
    //create for categories
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
  
    // create db connection
    $database = new Database();
    $db = $database->connect();
  
    // create category object
    $cat = new Category($db);

    // get input
    $data = json_decode(file_get_contents("php://input"));
    
   
    // check for data and if no data quit otherwise set category
    if(!isset($data->category)){echo json_encode(array('message' => 'Missing Required Parameters'));
    }
    else {
        $cat->category = $data->category;
        $cat->create();
        echo json_encode(array('id'=> $db->lastInsertId(),'category'=>$cat->category));
    }

