<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';


  $database = new Database();
  $db = $database->connect();

  $quotes = new Quote($db);

  if (isset($_GET['author_id'])) $quotes->author_id = $_GET['author_id'];
  if (isset($_GET['category_id'])) $quotes->category_id = $_GET['category_id'];

  $result = $quotes->read();

  $num = $result->rowCount();

  if ($num > 0)
  {
    $quotes_arr = array();
    $quotes_arr['Quotes'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $quote_item = array(
            'Id' => $id,
            'Quote' => html_entity_decode($quote),
            'Author' => $author,
            'Category' => $category
        );

     array_push($quotes_arr['Quotes'], $quote_item);

    }

    echo json_encode($quotes_arr);

  }
  else {
    echo json_encode(
    array('message' => "No Quotes Found!"));
  }