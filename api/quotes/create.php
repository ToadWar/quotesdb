<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
  
  
    $database = new Database();
    $db = $database->connect();
  
    $quo = new Quote($db);

    $auth = new Author($db);
    $cat = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    if ($data->quote && $data->author_id && $data->category_id){
               
        $quo->quote = $data->quote;
        $quo->author_id = $data->author_id;
        $quo->category_id = $data->category_id;

        $auth->id = $data->author_id;
        $cat->id = $data->category_id;

        if (!$auth->read_single()) echo json_encode(array('message' => 'author_id Does Not Exsist'));
        else if (!$cat->read_single()) echo json_encode(array('message' => 'category_id Does Not Exsist'));


        else  if ($quo->create()){
            echo json_encode(array('message' => 'Quote added'));
        }
        else
        {
            echo json_encode(array('message' => 'Quote not added'));
        }
    
    }
    else {
        echo json_encode(array('message' => 'Missing Required Parameters'));
    }