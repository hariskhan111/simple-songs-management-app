<?php
session_start();
require_once "config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);
  
    if(isset($putData['id']) && isset($putData['title']) && isset($putData['artist']) && isset($putData['genre'])) {
      $id = $putData['id'];
      $title = $putData['title'];
      $artist = $putData['artist'];
      $genre = $putData['genre'];
    
      echo $id . $title;
  
      $sql = "UPDATE songs SET title=:title, artist=:artist, genre=:genre WHERE id=:id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':artist', $artist);
      $stmt->bindParam(':genre', $genre);
      $stmt->execute();
  
      $db = null;
  
      // Return success response
      http_response_code(200);
      header("Location: ../index.php");
      exit();
    } else {
      // Return error response
      http_response_code(400);
      echo json_encode(array("message" => "Incomplete data. Please provide id, title, artist, and genre."));
      exit();
    }
  }
    
?>
