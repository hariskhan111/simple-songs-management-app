<?php
session_start();
require_once "config.php";


// Retrieve the existing song data
if(isset($_GET['songId'])) {
    $songId = $_GET['songId'];

    // Prepare and execute the SQL statement
    $sql = "SELECT * FROM songs WHERE id = :songId";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':songId', $songId);
    $stmt->execute();
    $song = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // Close the database connection
    $conn = null;
  
    // Return the song data as JSON response
    echo json_encode($song);
    exit();
  }
?>
