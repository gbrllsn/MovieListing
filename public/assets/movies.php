<?php
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';
Auth::gate();

require_once __DIR__ . '/../../app/config/config.php';

$movies = $pdo->query("SELECT * FROM movies ORDER BY release_date DESC")->fetchAll();

$base = '/MovieListing/public';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vesper — Movies</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;600;700&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">

<style>
.movie-card-vesper {
    cursor: pointer;
    transition: 0.25s;
}
.movie-card-vesper:hover {
    transform: scale(1.03);
}
</style>
</head>

<body>

<div class="hero-bg"></div>
<div class="hero-vignette"></div>

<nav class="vesper-nav">
    <div class="inner">
        <a href="movies.php" class="brand-title">VESPER</a>

        <div class="nav-group">

            <!-- Search -->
            <div style="position:relative;">

                <input type="text"
                       id="movieSearch"
                       placeholder="Search movies..."
                       class="field-input"
                       style="
                            width:220px;
                            padding:10px 14px;
                            font-size:11px;
                       ">

            </div>

            <?php if (!empty($_SESSION['is_admin'])): ?>
                <a href="../admin/admin.php" class="btn-primary-vesper"
                   style="
                        width:auto;
                        padding:10px 16px;
                        text-decoration:none;
                        margin-top:0;
                   ">
                    Admin
                </a>
            <?php endif; ?>

            <!-- Username button -->
            <a href="profile.php"
                style="
                        text-decoration:none;
                        padding:10px 18px;
                        border:1px solid #2f6b45;
                        background:#183524;
                        color:#8fffc0;
                        font-size:10px;
                        letter-spacing:0.18em;
                        text-transform:uppercase;
                        display:inline-block;
                ">
                <?= htmlspecialchars($_SESSION['username']) ?>
            </a>

            <a href="../../app/controllers/auth/logout.php"
               class="btn-danger-vesper">
                Terminate
            </a>

        </div>
    </div>
</nav>

<div class="main-content">
<div class="container">
<div class="row g-4">

<?php foreach ($movies as $movie): ?>

<?php
$poster = $movie['poster_path'] ?? null;

if (!$poster || trim($poster) === '') {
    $poster = $base . '/assets/uploads/posters/avatar.webp';
} else {
    $poster = $base . $poster; // IMPORTANT: DB already starts with /assets/...
}
?>

<div class="col-lg-3 col-md-4 col-6 movie-item"
     data-title="<?= htmlspecialchars($movie['title']) ?>">
<a href="/MovieListing/public/movie.php?id=<?= $movie['id'] ?>" style="text-decoration:none;">

<div class="movie-card-vesper">

    <div style="aspect-ratio:2/3; overflow:hidden;">
        <?php
        $base = '/MovieListing/public';

        if (empty($movie['poster_path'])) {
            $poster = $base . '/assets/uploads/posters/avatar.webp';
        } else {
            $poster = $base . $movie['poster_path'];
        }
        ?>

        <img src="<?= htmlspecialchars($poster) ?>"
             class="w-100 h-100"
             style="object-fit: cover;">
    </div>

    <div class="p-3">
        <div style="display:flex; justify-content:space-between; font-size:10px; color:#aaa;">
            <span><?= $movie['release_date'] ? date('Y', strtotime($movie['release_date'])) : 'N/A' ?></span>
            <span>★ <?= $movie['vote_average'] ?? '0.0' ?></span>
        </div>

        <div style="font-size:12px; color:#fff; text-transform:uppercase; margin-top:5px;">
            <?= htmlspecialchars($movie['title']) ?>
        </div>
    </div>

</div>

</a>

</div>

<?php endforeach; ?>

</div>
</div>
</div>

<script>
const searchInput = document.getElementById('movieSearch');

searchInput.addEventListener('keyup', function() {

    let value = this.value.toLowerCase();

    document.querySelectorAll('.movie-item').forEach(movie => {

        let title = movie.dataset.title.toLowerCase();

        if (title.includes(value)) {
            movie.style.display = '';
        } else {
            movie.style.display = 'none';
        }

    });

});
</script>

</body>
</html>