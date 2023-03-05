<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';


  $database = new Database();
  $db = $database->connect();

  $auth = new Author($db);

  $result = $auth->read();

  $num = $result->rowCount();

  if ($num > 0)
  {
    $authors_arr = array();
    $authors_arr['Authors'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $author_item = array(
            'id' => $id,
            'Author' => $author
        );

     array_push($authors_arr['Authors'], $author_item);

    }

    echo json_encode($authors_arr);

  }
  else {
    echo json_encode(
    array('message' => "No Authors Found!"));
  }