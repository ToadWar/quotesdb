<?php
    //Delete for authors
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
  
    // create db connection
    $database = new Database();
    $db = $database->connect();
  
    $auth = new Author($db); // create author object

    $data = json_decode(file_get_contents("php://input")); // get input

    // get author data then delete
    if (!isset($data->id)){
        echo(json_encode(array('message' => 'Missing Required Parameters'))); // if no data send message
    }
    else
    {
        $auth->id = $data->id;
        $auth->delete();
        echo(json_encode(array('id'=>$auth->id)));
        
    }
