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

    $auth->id = isset($_GET['id']) ? $_GET['id']: die();

    if ($auth->delete()){
        $message = array('deleted' => $auth->id);
    }
    else
    {
        $message = array('message' => 'No Authors Found!');
    }

    print_r(json_encode($message));