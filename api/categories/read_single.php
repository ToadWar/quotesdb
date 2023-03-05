<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Category.php';


  $database = new Database();
  $db = $database->connect();

  $cat = new Category($db);

  $cat->id = isset($_GET['id']) ? $_GET['id']: die();

  $cat->read_single();

  if($cat->category) {

    $cat_arr = array(
      'id' => $cat->id,
      'category' => $cat->category
    );
   }
 else {
   $cat_arr = array(
     'message' => 'category_id Not Found'
   );

 }

  print_r(json_encode($cat_arr));