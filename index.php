<?php
    require_once "backend/config.php";
    session_start();

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION["id"];
    // echo $user_id; die();

    $title = $_GET['title'] ?? '';
    $artist = $_GET['artist'] ?? '';
    $genre = $_GET['genre'] ?? '';

    $sql = "SELECT * FROM songs WHERE user_id = :user_id";
    $params = array(':user_id' => $user_id);

    // Include additional conditions if the search criteria are provided
    if (!empty($title)) {
        $sql .= " AND title LIKE :title";
        $params[':title'] = '%' . $title . '%';
    }

    if (!empty($artist)) {
        $sql .= " AND artist LIKE :artist";
        $params[':artist'] = '%' . $artist . '%';
    }

    if (!empty($genre)) {
        $sql .= " AND genre LIKE :genre";
        $params[':genre'] = '%' . $genre . '%';
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $search_detail = ['title' => $title, 'artist' => $artist, 'genre'=>$genre];
    $queryParams = http_build_query(array('songs' => $songs, 'search' => $search_detail));

    header("Location: songs.php?" . $queryParams);
    exit();

?>