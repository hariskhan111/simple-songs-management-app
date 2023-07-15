<?php
session_start();
require_once "config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $artist = $_POST["artist"];
    $genre = $_POST["genre"];
    $user_id = $_SESSION["id"];


    // Insert the user into the database
    $stmt = $db->prepare("INSERT INTO songs (title, artist, genre, user_id) VALUES (:title, :artist, :genre, :user_id)");
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":artist", $artist);
    $stmt->bindParam(":genre", $genre);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    header("Location: ../index.php");
    exit();
}
?>
