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
      'Id' => $quo->id,
      'Quote' => $quo->quote,
      'Author' => $quo->author,
      'Category' => $quo->category
    );
   }
 else {
   $quote_arr = array(
     'Message' => 'quote_id Not Found'
   );

 }

  print_r(json_encode($quote_arr));