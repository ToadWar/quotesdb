<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
  
  
    $database = new Database();
    $db = $database->connect();
  
    $quo = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!$data){
        echo(json_encode(array('message' => 'No Quotes Found')));
    }
    else
    {
        $quo->id = $data->id;
        $auth->delete();
        echo(json_encode(array('id'=>$auth->id)));
    }
    