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
  $post->id = isset($_GET['id']) ? $_GET['id'] : die();
  $post->type = isset($_GET['type']) ? $_GET['type'] : die();

  $result = $post->read_single();
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

    // Headers
    /* header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
  
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';
  
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
  
    // Instantiate blog post object
    $post = new Post($db);
  
    // Blog post query
    $result = $post->read_ss();
    // Get row count
    $num = $result->rowCount();
  
    // Check if any posts
    if($num > 0) {
      // Post array
      $posts_arr = array();
      // $posts_arr['data'] = array();
  
      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
  
        $post_item = array(
          'id' => $id,
          'name' => $name,
          'service_id' => $service_id
        );
  
        // Push to "data"
        array_push($posts_arr, $post_item);
        // array_push($posts_arr['data'], $post_item);
      }
  
      // Turn to JSON & output
      echo json_encode($posts_arr);
  
    } else {
      // No Posts
      echo json_encode(
        array('message' => 'No Posts Found')
      );
    } */