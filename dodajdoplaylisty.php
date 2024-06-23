<?php
include 'db.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_playlist_btn'])) {
    $song_id = $_POST['song_id'];
    $playlist_id = $_POST['playlist_id'];


    if (is_numeric($song_id) && is_numeric($playlist_id)) {
        $sql = "INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$playlist_id, $song_id]);



            header("Location: nowa-playlista.php?id=" . $playlist_id);
            exit();
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    } else {
        echo "Nieprawidłowe ID utworu lub playlisty.";
    }
}

$pdo = null;
?>
