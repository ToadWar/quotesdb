<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Tupe:application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //create database connection
    $database = new Database();
    $db = $database->connect();

    //create quote object
    $quotes = new Quote($db);

    // get data if data is set 
    if (isset($_GET['author_id'])) $quotes->author_id = $_GET['author_id'];
    if (isset($_GET['category_id'])) $quotes->category_id = $_GET['category_id'];

    // get results from db
    $result = $quotes->read();

    // count rows
    $num = $result->rowCount();
    // if rows then create array of data and echo
    if ($num > 0)
    {
      $quotes_arr = array();


      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $quote_item = array(
              'id' => $id,
              'quote' => html_entity_decode($quote),
              'author' => $author,
              'category' => $category
          );

      array_push($quotes_arr, $quote_item);

      }

      echo json_encode($quotes_arr);

    }
    // if fails echo
    else {
      echo json_encode(
      array('message' => "No Quotes Found!"));
    }