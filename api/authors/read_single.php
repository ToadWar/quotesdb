<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';


  $database = new Database();
  $db = $database->connect();

  $auth = new Author($db);

  $auth->id = isset($_GET['id']) ? $_GET['id']: die();

  $auth->read_single();

  if($auth->author) {

     echo json_encode(array(
       'id' => $auth->id,
        'author' => $auth->author
     ));
    }
  else {
    echo json_encode(array(
      'message' => 'author_id Not Found'
    ));
    return false;
    

  }