<?php
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';
Auth::gate();

require_once __DIR__ . '/../../app/config/config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../assets/movies.php');
    exit();
}

/* ─────────────────────────────
   GET MOVIE
───────────────────────────── */
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Movie ID missing.");
}

$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);

$movie = $stmt->fetch();

if (!$movie) {
    die("Movie not found.");
}

/* ─────────────────────────────
   HANDLE UPDATE
───────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // Keep old poster by default
        $posterPath = $movie['poster_path'];

        // Upload new image if selected
        if (!empty($_FILES['poster']['name'])) {

            $uploadDir = __DIR__ . '/../assets/uploads/posters/';

            // Create folder if missing
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Unique filename
            $fileName = time() . '_' . basename($_FILES['poster']['name']);

            // Full save path
            $targetFile = $uploadDir . $fileName;

            // Move uploaded file
            if (
                move_uploaded_file(
                    $_FILES['poster']['tmp_name'],
                    $targetFile
                )
            ) {

                // Save DB path
                $posterPath = '/assets/uploads/posters/' . $fileName;

            } else {

                die("Image upload failed.");

            }
        }

        // UPDATE DATABASE
        $stmt = $pdo->prepare("
            UPDATE movies SET
                tmdb_id = ?,
                title = ?,
                overview = ?,
                release_date = ?,
                genre_ids = ?,
                poster_path = ?,
                vote_average = ?,
                vote_count = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $_POST['tmdb_id'],
            $_POST['title'],
            $_POST['overview'],
            $_POST['release_date'],
            $_POST['genre_ids'],
            $posterPath,
            $_POST['vote_average'],
            $_POST['vote_count'],
            $_POST['id']
        ]);

        header("Location: admin.php?updated=1");
        exit();

    } catch (PDOException $e) {

        die("Update failed: " . $e->getMessage());

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<title>Vesper - Edit Movie</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    background:#08080a;
    color:white;
    font-family:'Outfit',sans-serif;
}

.wrapper{
    max-width:900px;
    margin:auto;
    padding-top:100px;
    padding-bottom:50px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}

.page-title{
    font-family:'Cormorant Garamond';
    font-size:3rem;
    margin:0;
}

.back-btn{
    text-decoration:none;
    padding:10px 20px;
    border:1px solid #2d4d7a;
    background:#162133;
    color:#8eb8ff;
    font-size:10px;
    letter-spacing:.18em;
    text-transform:uppercase;
    transition:.2s;
}

.back-btn:hover{
    background:#1d2b42;
    color:#c3dcff;
}

.panel{
    background:#101014;
    border:1px solid #222;
    padding:35px;
}

.form-control{
    background:#0d0d10;
    border:1px solid #2a2a2a;
    color:white;
    padding:14px;
}

.form-control:focus{
    background:#0d0d10;
    color:white;
    border-color:#555;
    box-shadow:none;
}

input[type="file"]::file-selector-button{
    background:#1a1d24;
    color:#c9d4e5;
    border:none;
    padding:10px 16px;
    margin-right:15px;
    cursor:pointer;
    transition:.2s;
}

input[type="file"]::file-selector-button:hover{
    background:#252b36;
}

textarea{
    height:120px;
    resize:none;
}

label{
    margin-bottom:10px;
    font-size:.8rem;
    letter-spacing:2px;
    color:#888;
}

.submit-btn{
    width:100%;
    padding:14px;
    background:#4ade80;
    border:none;
    color:#08110c;
    font-weight:600;
    letter-spacing:.12em;
    text-transform:uppercase;
    margin-top:20px;
    transition:.2s;
}

.submit-btn:hover{
    background:#65f09a;
}

</style>

</head>

<body>

<div class="container wrapper">

    <div class="top-bar">

        <div>
            <p style="color:#777;margin-bottom:5px;">
                ADMIN PANEL
            </p>

            <h1 class="page-title">
                Edit Movie
            </h1>
        </div>

        <a href="admin.php" class="back-btn">
            ← Back
        </a>

    </div>

    <div class="panel">

        <form method="POST" enctype="multipart/form-data">

            <input
                type="hidden"
                name="id"
                value="<?= $movie['id'] ?>">

            <div class="row">

                <!-- TMDB ID -->
                <div class="col-md-6 mb-4">

                    <label>TMDB ID</label>

                    <input
                        type="number"
                        name="tmdb_id"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['tmdb_id']) ?>"
                        required>

                </div>

                <!-- TITLE -->
                <div class="col-md-6 mb-4">

                    <label>MOVIE TITLE</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['title']) ?>"
                        required>

                </div>

                <!-- OVERVIEW -->
                <div class="col-12 mb-4">

                    <label>OVERVIEW</label>

                    <textarea
                        name="overview"
                        class="form-control"><?= htmlspecialchars($movie['overview']) ?></textarea>

                </div>

                <!-- RELEASE DATE -->
                <div class="col-md-6 mb-4">

                    <label>RELEASE DATE</label>

                    <input
                        type="date"
                        name="release_date"
                        class="form-control"
                        value="<?= $movie['release_date'] ?>">

                </div>

                <!-- GENRE IDS -->
                <div class="col-md-6 mb-4">

                    <label>GENRE IDS</label>

                    <input
                        type="text"
                        name="genre_ids"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['genre_ids']) ?>"
                        placeholder="12,18,878">

                </div>

                <!-- RATING -->
                <div class="col-md-6 mb-4">

                    <label>RATING</label>

                    <input
                        type="number"
                        step="0.1"
                        name="vote_average"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['vote_average']) ?>">

                </div>

                <!-- VOTE COUNT -->
                <div class="col-md-6 mb-4">

                    <label>VOTE COUNT</label>

                    <input
                        type="number"
                        name="vote_count"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['vote_count']) ?>"
                        placeholder="38000">

                </div>

                <!-- POSTER -->
                <div class="col-12 mb-4">

                    <label>POSTER IMAGE (optional)</label>

                    <input
                        type="file"
                        name="poster"
                        class="form-control"
                        accept="image/*">

                    <?php
                    $poster = !empty($movie['poster_path'])
                        ? '/MovieListing/public' . $movie['poster_path']
                        : '/MovieListing/public/assets/uploads/posters/avatar.webp';
                    ?>

                    <div style="margin-top:15px;">

                        <img
                            src="<?= htmlspecialchars($poster) ?>"
                            style="
                                width:140px;
                                border:1px solid #333;
                                border-radius:4px;
                                object-fit:cover;
                            ">

                    </div>

                </div>

            </div>

            <button class="submit-btn">
                UPDATE MOVIE
            </button>

        </form>

    </div>

</div>

</body>
</html>