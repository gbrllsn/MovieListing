<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

Auth::adminOnly();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // Default poster path
        $posterPath = null;

        // Upload image
        if (!empty($_FILES['poster']['name'])) {

            $uploadDir = __DIR__ . '/../../../public/assets/uploads/posters/';

            // Create folder if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Unique filename
            $filename = time() . '_' . basename($_FILES['poster']['name']);

            // Full file path
            $targetPath = $uploadDir . $filename;

            // Move uploaded file
            if (
                move_uploaded_file(
                    $_FILES['poster']['tmp_name'],
                    $targetPath
                )
            ) {

                // Save path into DB
                $posterPath = '/assets/uploads/posters/' . $filename;

            } else {

                die('Image upload failed.');

            }
        }

        // Insert movie
        $stmt = $pdo->prepare("
            INSERT INTO movies (
                tmdb_id,
                title,
                overview,
                release_date,
                genre_ids,
                poster_path,
                vote_average,
                vote_count
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST['tmdb_id'],
            $_POST['title'],
            $_POST['overview'],
            $_POST['release_date'],
            $_POST['genre_ids'],
            $posterPath,
            $_POST['vote_average'],
            $_POST['vote_count']
        ]);

        header('Location: ../../../public/admin/addMovie.php?success=1');
        exit();

    } catch (PDOException $e) {

        die($e->getMessage());

    }
}
?>