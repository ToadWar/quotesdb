<?php
    // update for authors
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
  
  
    // create db connection
    $database = new Database();
    $db = $database->connect();
  
    $auth = new Author($db); // create author object

    // get data and if missing data send message and quit
    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id)|| !isset($data->author) ) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    //set variables
    $auth->author = $data->author;
    $auth->id = $data->id;
    
    //update author
    if ($auth->update()){
        echo json_encode(array('id'=>$auth->id,'author'=>$auth->author));
    }
    else
    {
        echo json_encode(array('message' => 'author_id Not Found')); // if no author found
    }
