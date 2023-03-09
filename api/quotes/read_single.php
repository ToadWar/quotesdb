<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  //create database connection
  $database = new Database();
  $db = $database->connect();

  //create quote object
  $quo = new Quote($db);

  // get data
  $quo->id = isset($_GET['id']) ? $_GET['id']: die();
   
  // read and create an array of result
  if($quo->read_single()) {

    $quote_arr = array(
      'id' => $quo->id,
      'quote' => $quo->quote,
      'author' => $quo->author,
      'category' => $quo->category
    );
   }
   // if fail message
 else {
   $quote_arr = array(
     'message' => 'No Quotes Found'
   );

 }

  echo(json_encode($quote_arr));