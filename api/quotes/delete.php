<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
  
   //create database connection
    $database = new Database();
    $db = $database->connect();
  
    //create quote object
    $quo = new Quote($db);

    // get data
    $data = json_decode(file_get_contents("php://input"));

    // if data not set, message and exit
    if (!isset($data->id)){
        echo(json_encode(array('message'=> 'Missing Required Parameters')));
        exit();
    }
    
    // attempt delete
    $quo->id = $data->id;
    if ($quo->delete())
     {
        echo(json_encode(array('id'=>$quo->id)));
    }
    // if delete fails, message
    else{
        echo(json_encode(array('message'=> 'No Quotes Found')));
    }
    