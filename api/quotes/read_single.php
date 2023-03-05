<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';


  $database = new Database();
  $db = $database->connect();

  $quo = new Quote($db);

  $quo->id = isset($_GET['id']) ? $_GET['id']: die();
 

  $quo->read_single();

  

  if($quo->quote) {

    $quote_arr = array(
      'id' => $quo->id,
      'quote' => $quo->quote,
      'author' => $quo->author,
      'category' => $quo->category
    );
   }
 else {
   $quote_arr = array(
     'message' => 'No Quotes Found'
   );

 }

  print_r(json_encode($quote_arr));