<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';
Auth::gate();

require_once __DIR__ . '/../app/config/config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Movie ID missing");
}

$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) {
    die("Movie not found");
}

/* ── Poster fallback ── */
$base = '/MovieListing/public';
$poster = $movie['poster_path'];

if (empty($poster)) {
    $poster = $base . '/assets/uploads/posters/avatar.webp';
} else {
    $poster = $base . $poster;
}

/* ── Reviews ── */
$revStmt = $pdo->prepare("
    SELECT ur.*, u.username
    FROM user_reviews ur
    JOIN users u ON ur.user_id = u.id
    WHERE ur.movie_id = ?
    ORDER BY ur.created_at DESC
");
$revStmt->execute([$id]);
$reviews = $revStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($movie['title']) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">

<style>
.page-wrap { padding: 3.5rem 0 5rem; }

.collection-panel {
    background: rgba(14,14,18,0.94);
    border: 1px solid var(--border);
    border-radius: 2px;
    position: relative;
    z-index: 5;
}

.movie-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem;
    font-weight: 600;
    color: #fff;
}

.movie-meta {
    font-size: 13px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-top: 1rem;
    line-height: 1.9;
}

.review-box {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.review-item {
    padding: 1rem 0;
    border-bottom: 1px solid var(--border);
}
.review-item:last-child { border-bottom: none; }

.review-user {
    font-size: 9px;
    letter-spacing: 0.18em;
    color: var(--accent);
    text-transform: uppercase;
}

.review-text {
    font-size: 0.85rem;
    color: var(--text-sub);
}
</style>
</head>

<body>

<div class="hero-bg"></div>
<div class="hero-vignette"></div>

<nav class="vesper-nav">
    <div class="inner">
        <a href="assets/movies.php" class="brand-title">VESPER</a>
        <div class="nav-group" style="display:flex; gap:12px; align-items:center;">

            <input type="text"
                id="movieSearch"
                placeholder="Search movies..."
                class="field-input"
                style="
                        width:180px;
                        padding:10px 14px;
                        font-size:11px;
                "
                onkeyup="searchMovie()">
            <a href="/MovieListing/public/assets/movies.php"
                style="
                    text-decoration:none;
                    padding:10px 18px;
                    border:1px solid #2d4d7a;
                    background:#162133;
                    color:#8eb8ff;
                    font-size:10px;
                    letter-spacing:0.18em;
                    text-transform:uppercase;
                ">
                Catalogue
            </a>
            <a href="../app/controllers/auth/logout.php" class="btn-danger-vesper">Terminate</a>
        </div>
    </div>
</nav>

<div class="main-content">
<div class="container">
<div class="page-wrap">

<div class="row g-4">

<!-- LEFT -->
<div class="col-md-4">
    <?php
    $base = '/MovieListing/public';

    if (empty($movie['poster_path'])) {
        $poster = $base . '/assets/uploads/posters/avatar.webp';
    } else {
        $poster = $base . $movie['poster_path'];
    }
    ?>

    <img src="<?= htmlspecialchars($poster) ?>"
        class="w-100" style="border-radius:4px;">
</div>

<!-- RIGHT -->
<div class="col-md-8">

    <div class="collection-panel p-4">

        <h1 class="movie-title">
            <?= htmlspecialchars($movie['title']) ?>
        </h1>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'review_saved'): ?>
            <div style="padding:10px; margin-top:10px; border:1px solid var(--accent-border); color:var(--accent); font-size:10px; letter-spacing:0.2em;">
                REVIEW SAVED SUCCESSFULLY
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['watchlist'])): ?>
            <div style="padding:10px; margin-top:10px; border:1px solid var(--accent-border); color:var(--accent); font-size:10px;">
                ADDED TO WATCHLIST
            </div>
        <?php endif; ?>

        <p class="mt-3" style="color:var(--text-sub);">
            <?= htmlspecialchars($movie['overview']) ?>
        </p>

        <div class="movie-meta">
            Rating: <?= $movie['vote_average'] ?? '0.0' ?> / 10 <br>
            Release: <?= $movie['release_date'] ?? 'N/A' ?>
        </div>

        <!-- ADD REVIEW -->
        <div class="review-box">

            <h5 style="font-size:10px; letter-spacing:0.2em; color:var(--accent);">
                ADD REVIEW
            </h5>

            <form method="POST" enctype="multipart/form-data" action="../app/controllers/movies/updateStatus.php">

                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">

                <input type="number"
                       name="rating"
                       min="1" max="10"
                       placeholder="Rating (1–10)"
                       class="field-input mt-2">

                <textarea name="review"
                          placeholder="Write your review..."
                          class="field-input mt-2"></textarea>

                <button type="submit"
                        class="mt-3"
                        style="
                            background:#b38a28;
                            border:none;
                            color:white;
                            padding:12px 18px;
                            font-size:10px;
                            letter-spacing:0.18em;
                            text-transform:uppercase;
                        ">
                    Submit Review
                </button>

            </form>

            <form method="POST" enctype="multipart/form-data" action="../app/controllers/movies/watchlist.php">

                    <input type="hidden"
                        name="movie_id"
                        value="<?= $movie['id'] ?>">

                    <button type="submit"
                            class="mt-2"
                            style="
                                background:#1d6f42;
                                border:none;
                                color:white;
                                padding:12px 18px;
                                font-size:10px;
                                letter-spacing:0.18em;
                                text-transform:uppercase;
                            ">
                        Add To Watchlist
                    </button>

            </form>
        </div>

        <!-- REVIEWS LIST -->
        <div class="review-box">
            <h5 style="font-size:10px; letter-spacing:0.2em; color:var(--accent);">
                REVIEWS
            </h5>

            <?php if (!$reviews): ?>
                <p style="color:var(--text-muted); font-size:0.85rem;">
                    No reviews yet.
                </p>
            <?php else: ?>
                <?php foreach ($reviews as $r): ?>
                    <div class="review-item">
                        <div class="review-user">
                            <?= htmlspecialchars($r['username']) ?>
                        </div>
                        <div class="review-text">
                            <?= htmlspecialchars($r['review']) ?>
                        </div>
                        <div style="font-size:9px; color:var(--text-muted);">
                            Rating: <?= $r['rating'] ?>/10
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

</div>

</div>

</div>
</div>
<script>
function searchMovie() {

    let value = document
        .getElementById('movieSearch')
        .value
        .toLowerCase();

    if (value.length < 1) {
        return;
    }

    window.location.href =
        '/MovieListing/public/assets/movies.php?search=' +
        encodeURIComponent(value);
}
</script>
</body>
</html>