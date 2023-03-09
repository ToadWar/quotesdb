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

    //get an array of data
    $result = $cat->read();

    // count ros
    $num = $result->rowCount();

    // if there are rows create an array of json data and return
    if ($num > 0)
    {
      $category_arr = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $cat_item = array(
              'id' => $id,
              'category' => $category
          );

      array_push($category_arr, $cat_item);

      }

      echo json_encode($category_arr);

    }
    // if there are no rows then message
    else {
      echo json_encode(
      array('message' => "No Categories Found!"));
    }