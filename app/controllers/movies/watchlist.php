<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$movie_id = $_POST['movie_id'] ?? null;

if (!$movie_id) {
    die("Movie ID missing");
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO watchlist (user_id, movie_id)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE movie_id = movie_id
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $movie_id
    ]);

    header("Location: /MovieListing/public/movie.php?id=$movie_id&watchlist=added");
    exit;

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}