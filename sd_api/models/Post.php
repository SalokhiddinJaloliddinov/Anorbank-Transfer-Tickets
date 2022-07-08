<?php 
  class Post {
    // DB stuff
    private $conn;

    // Post Properties 

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT 
      s.id, s.name
  FROM
      service AS s
          JOIN
      servicesubcategory AS ss ON s.id = ss.service_id
  WHERE
      ss.request_type = ?
  GROUP BY s.id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->type);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Posts
    /* public function read_ss() {
      // Create query
      $query = 'SELECT
                id,
                name,
                service_id
                FROM
                servicesubcategory';
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    } */

    // Get Single Post
    public function read_single() {
      // Create query
      $query = 'SELECT
                id,
                name,
                service_id
                FROM 
                servicesubcategory
                WHERE service_id = :id AND request_type = :type';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam('id', $this->id);
      $stmt->bindParam('type', $this->type, PDO::PARAM_STR);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    
}

