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

     $auth_arr = array(
       'id' => $auth->id,
        'author' => $auth->author
     );
    }
  else {
    $auth_arr = array(
      'Message' => 'author_id Not Found'
    );

  }

  print_r(json_encode($auth_arr));