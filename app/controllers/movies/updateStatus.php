<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$movie_id = $_POST['movie_id'] ?? null;
$rating    = $_POST['rating'] ?? null;
$review    = $_POST['review'] ?? null;

if (!$movie_id) {
    die("Movie ID missing");
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO user_reviews (user_id, movie_id, rating, review)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            rating = VALUES(rating),
            review = VALUES(review)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $movie_id,
        $rating,
        $review
    ]);

    header("Location: /MovieListing/public/movie.php?id=$movie_id&success=review_saved");
    exit;

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}