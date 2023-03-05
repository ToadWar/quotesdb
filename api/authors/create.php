<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
  
  
    $database = new Database();
    $db = $database->connect();
  
    $auth = new Author($db);

    $data = json_decode(file_get_contents("php://input"));
    
    $auth->author = $data->author;
     

    if ($auth->create()){
        echo json_encode(array('id'=> $db->lastInsertId(),'author'=>$auth->author));
    }
    else
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
    }
