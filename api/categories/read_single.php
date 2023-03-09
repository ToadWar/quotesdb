<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Tupe:application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

  //create database object
    $database = new Database();
    $db = $database->connect();

    // create category object
    $cat = new Category($db);

    // get id
    $cat->id = isset($_GET['id']) ? $_GET['id']: die();

    
    //try to read the id and echo
    if($cat->read_single()) {

      echo json_encode(array(
        'id' => $cat->id,
        'category' => $cat->category
      ));
    }
    // if unable to read id
  else {
      echo json_encode(array(
      'message' => 'category_id Not Found'
    ));

  }

  