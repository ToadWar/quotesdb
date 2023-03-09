<?php
    //create for quotes
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
  
    //create database connection
    $database = new Database();
    $db = $database->connect();
    
    //create quote object
    $quo = new Quote($db);
    //create auth and cat object for checks
    $auth = new Author($db);
    $cat = new Category($db);

    // get data
    $data = json_decode(file_get_contents("php://input"));

    // if data not set, message and exit
    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id))
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();

    }
        //set datat
        $quo->quote = $data->quote;
        $quo->author_id = $data->author_id;
        $quo->category_id = $data->category_id;

        $auth->id = $data->author_id;
        $cat->id = $data->category_id;
        
        // run checks
        $auth->read_single();
        $cat->read_single();

        // if checks fail message
        if (!$auth->author) { echo json_encode(array('message' => 'author_id Not Found')); }
        else if (!$cat->category) { echo json_encode(array('message' => 'category_id Not Found'));}
        
        // if not create
        else if ($quo->create()){
            echo json_encode(array('id'=> $db->lastInsertId(),'quote'=> $quo->quote, 'author_id'=>$quo->author_id, 'category_id'=>$quo->category_id));
        }
        // if something else happened message
        else
        {
            echo json_encode(array('message' => 'Quote not added'));
        }
    
  
