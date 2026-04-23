<?php
session_start();
require_once '../config/database.php';

if ($pdo === false) {
    // Handle API requests even if DB fails
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode(['success' => false, 'message' => 'Database connection failed. Please check if MySQL is running.']);
        exit;
    }
}

class MovieController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function addToWatchlist($userId, $tmdbId, $title, $overview, $releaseDate, $posterPath, $genreIds, $voteAverage, $voteCount) {
        // First, ensure movie exists in movies table
        $this->ensureMovieExists($tmdbId, $title, $overview, $releaseDate, $posterPath, $genreIds, $voteAverage, $voteCount);

        // Get movie id
        $stmt = $this->pdo->prepare("SELECT id FROM movies WHERE tmdb_id = ?");
        $stmt->execute([$tmdbId]);
        $movie = $stmt->fetch();
        if (!$movie) {
            return ['success' => false, 'message' => 'Movie not found'];
        }

        // Check if already in watchlist
        $stmt = $this->pdo->prepare("SELECT id FROM user_movies WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movie['id']]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Movie already in your list'];
        }

        // Add to watchlist
        $stmt = $this->pdo->prepare("INSERT INTO user_movies (user_id, movie_id, status) VALUES (?, ?, 'want_to_watch')");
        if ($stmt->execute([$userId, $movie['id']])) {
            return ['success' => true, 'message' => 'Added to watchlist'];
        } else {
            return ['success' => false, 'message' => 'Failed to add to watchlist'];
        }
    }

    public function updateMovieStatus($userId, $tmdbId, $status, $rating = null, $review = null, $dateWatched = null) {
        // Get movie id
        $stmt = $this->pdo->prepare("SELECT id FROM movies WHERE tmdb_id = ?");
        $stmt->execute([$tmdbId]);
        $movie = $stmt->fetch();
        if (!$movie) {
            return ['success' => false, 'message' => 'Movie not found'];
        }

        // Update or insert
        $stmt = $this->pdo->prepare("INSERT INTO user_movies (user_id, movie_id, status, rating, review, date_watched) 
                                     VALUES (?, ?, ?, ?, ?, ?) 
                                     ON DUPLICATE KEY UPDATE status = VALUES(status), rating = VALUES(rating), review = VALUES(review), date_watched = VALUES(date_watched)");
        if ($stmt->execute([$userId, $movie['id'], $status, $rating, $review, $dateWatched])) {
            return ['success' => true, 'message' => 'Movie status updated'];
        } else {
            return ['success' => false, 'message' => 'Failed to update movie status'];
        }
    }

    public function getUserMovies($userId, $status = null) {
        $query = "SELECT m.*, um.status, um.rating, um.review, um.date_watched 
                  FROM user_movies um 
                  JOIN movies m ON um.movie_id = m.id 
                  WHERE um.user_id = ?";
        $params = [$userId];

        if ($status) {
            $query .= " AND um.status = ?";
            $params[] = $status;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private function ensureMovieExists($tmdbId, $title, $overview, $releaseDate, $posterPath, $genreIds, $voteAverage, $voteCount) {
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO movies (tmdb_id, title, overview, release_date, poster_path, genre_ids, vote_average, vote_count) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tmdbId, $title, $overview, $releaseDate, $posterPath, json_encode($genreIds), $voteAverage, $voteCount]);
    }
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Not logged in']);
        exit;
    }

    $movieController = new MovieController();
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add_to_watchlist':
            $result = $movieController->addToWatchlist(
                $_SESSION['user_id'],
                $_POST['tmdb_id'],
                $_POST['title'],
                $_POST['overview'],
                $_POST['release_date'],
                $_POST['poster_path'],
                $_POST['genre_ids'],
                $_POST['vote_average'],
                $_POST['vote_count']
            );
            echo json_encode($result);
            break;
        case 'update_status':
            $result = $movieController->updateMovieStatus(
                $_SESSION['user_id'],
                $_POST['tmdb_id'],
                $_POST['status'],
                $_POST['rating'] ?? null,
                $_POST['review'] ?? null,
                $_POST['date_watched'] ?? null
            );
            echo json_encode($result);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Not logged in']);
        exit;
    }

    $movieController = new MovieController();
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'get_user_movies':
            $status = $_GET['status'] ?? null;
            $movies = $movieController->getUserMovies($_SESSION['user_id'], $status);
            echo json_encode(['success' => true, 'movies' => $movies]);
            break;
    }
}
?>