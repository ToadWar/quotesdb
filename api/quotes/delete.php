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
        $message = array('message' => 'Quote id '.$quo->id.' deleted');
    }
    else
    {
        $message = array('message' => 'No Quotes Found');
    }
    print_r(json_encode($message));