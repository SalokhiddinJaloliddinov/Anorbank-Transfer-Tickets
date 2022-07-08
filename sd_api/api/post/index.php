<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->type = isset($_GET['type']) ? $_GET['type'] : die();

  $result = $post->read();
  $num = $result->rowCount();

  if($num > 0) {
      $post_arr = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $post_item = array (
            'id' => $id,
            'name' => $name
          );
        
        array_push($post_arr, $post_item);
      };
  };

  // Make JSON
  print_r(json_encode($post_arr));
  