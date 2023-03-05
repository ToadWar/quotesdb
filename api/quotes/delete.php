<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
  
  
    $database = new Database();
    $db = $database->connect();
  
    $quo = new Quote($db);

    $quo->id = isset($_GET['id']) ? $_GET['id']: die();

    if ($quo->delete()){
        echo json_encode(array('message' => 'Quote id '.$quo->id.' deleted'));
    }
    else
    {
        echo json_encode(array('message' => 'No Quotes Found'));
    }