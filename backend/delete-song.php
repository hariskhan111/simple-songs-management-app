<?php
session_start();
require_once "config.php";



// Delete a song
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
    echo 2323;
    parse_str(file_get_contents("php://input"), $deleteData);
  
    if(isset($deleteData['songId'])) {
      $id = $deleteData['songId'];
  
  
      $sql = "DELETE FROM songs WHERE id=:id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
  
      $conn = null;
  
      // Return success response
      http_response_code(200);
      echo json_encode(array("message" => "Song deleted successfully."));
      header("Location: ../index.php");
      exit();
    } else {
      // Return error response
      http_response_code(400);
      echo json_encode(array("message" => "Incomplete data. Please provide id."));
      exit();
    }
  }
  ?>
