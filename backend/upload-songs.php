<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION["id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['songsFile']) && $_FILES['songsFile']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['songsFile'];

        $songs_data = file_get_contents($file['tmp_name']);

        $lines = explode(PHP_EOL, $songs_data);

        $valid_songs = [];

        foreach ($lines as $line) {
            $fields = explode(',', $line);

            $fields = array_map('trim', $fields);

            if (count($fields) === 3 && !empty($fields[0]) && !empty($fields[1]) && !empty($fields[2])) {
                $valid_songs[] = [
                    'title' => $fields[0],
                    'artist' => $fields[1],
                    'genre' => $fields[2],
                    'user_id' => $id
                ];
            }
        }

        if (!empty($valid_songs)) {

            $stmt = $db->prepare("INSERT INTO songs (title, artist, genre, user_id) VALUES (:title, :artist, :genre, :user_id)");

            foreach ($valid_songs as $song) {
                $title = $song['title'];
                $artist = $song['artist'];
                $genre = $song['genre'];
                $user_id = $song['user_id'];
                $stmt->bindParam(":title", $title);
                $stmt->bindParam(":artist", $artist);
                $stmt->bindParam(":genre", $genre);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->execute();
            }

            echo 'File uploaded and songs inserted successfully.';
            header("Location: ../index.php");
            exit();
        } else {
            http_response_code(400);
            echo 'No valid songs found in the file.';
            exit();
        }
    }
}

// Return an error response if the request method or file upload is invalid
http_response_code(400);
echo 'Invalid request or file upload.';
?>
