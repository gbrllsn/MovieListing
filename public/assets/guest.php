<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: movies.php');
    exit();
}

require_once __DIR__ . '/../../app/config/config.php';

$movies = $pdo->query("
    SELECT *
    FROM movies
    ORDER BY id DESC
")->fetchAll();

$base = '/MovieListing/public';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vesper — Guest Discovery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;600;700&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .page-wrap {
            padding: 3.5rem 0 5rem;
        }

        .discovery-header {
            padding: 3.5rem 0 2.5rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2.5rem;
        }

        .movie-name {
            font-family: 'Outfit', sans-serif;
            font-size: 0.78rem;
            font-weight: 400;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #fff;
            line-height: 1.3;
        }

        .search-box {
            margin-top: 2rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            background: rgba(14,14,18,0.94);
            border: 1px solid var(--border);
            color: white;
            padding: 14px 16px;
            outline: none;
            font-size: 0.9rem;
        }

        .search-input:focus {
            border-color: var(--accent);
        }

        .suggestions {
            position: absolute;
            width: 100%;
            background: #0f1117;
            border: 1px solid var(--border);
            border-top: none;
            z-index: 50;
            display: none;
            max-height: 260px;
            overflow-y: auto;
        }

        .suggestion-item {
            padding: 12px 16px;
            font-size: 0.82rem;
            color: white;
            cursor: pointer;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }

        .suggestion-item:hover {
            background: rgba(255,255,255,0.04);
        }

        .guest-link {
            color: #8eb8ff;
            text-decoration: none;
        }

        .guest-link:hover {
            opacity: 0.8;
        }

        .signin-btn {
            text-decoration: none;
            padding: 10px 18px;
            border: 1px solid #2d4d7a;
            background: #162133;
            color: #8eb8ff;
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .signin-btn:hover {
            background: #1b2940;
        }
    </style>
</head>

<body>

<div class="hero-bg"></div>
<div class="hero-vignette"></div>

<nav class="vesper-nav">
    <div class="inner">

        <a href="index.php"
           class="brand-title"
           style="font-size: 1.75rem;">
            VESPER
        </a>

        <div class="nav-group">

            <span class="field-label"
                  style="color: var(--text-muted);">
                Viewing as Guest
            </span>

            <a href="index.php" class="signin-btn">
                Sign In
            </a>

        </div>
    </div>
</nav>

<div class="main-content">
<div class="container">
<div class="page-wrap">

    <div class="discovery-header anim-1">

        <span class="brand-label">
            Public Index
        </span>

        <h1 class="section-heading mt-2">
            Discovery
        </h1>

        <div class="brand-rule"></div>

        <!-- SEARCH -->
        <div class="search-box">

            <input type="text"
                   id="searchInput"
                   class="search-input"
                   placeholder="Search movies...">

            <div class="suggestions" id="suggestions"></div>

        </div>

    </div>

    <div class="guest-notice mb-5 anim-2">
        <p>
            You are browsing in read-only mode.
            <a href="index.php" class="guest-link">
                Create an account
            </a>
            to save movies to your watchlist and write reviews.
        </p>
    </div>

    <div class="row g-4 anim-3" id="movieGrid">

        <?php foreach ($movies as $m): ?>

            <?php
                if (empty($m['poster_path'])) {
                    $poster = $base . '/assets/uploads/posters/avatar.webp';
                } else {
                    $poster = $base . '/assets/uploads/posters/' . $m['poster_path'];
                }
            ?>

            <div class="col-lg-3 col-md-4 col-6 movie-item"
                 data-title="<?= strtolower(htmlspecialchars($m['title'])) ?>">

                <div class="movie-card-vesper"
                     onclick="alert('You must login or register first')"
                     style="cursor:pointer;">

                    <div style="aspect-ratio:2/3; overflow:hidden;">

                        <?php
                        $base = '/MovieListing/public';

                        if (empty($m['poster_path'])) {
                            $poster = $base . '/assets/uploads/posters/avatar.webp';
                        } else {
                            $poster = $base . $m['poster_path'];
                        }
                        ?>

                        <img src="<?= htmlspecialchars($poster) ?>"
                             class="w-100 h-100"
                             style="object-fit:cover;">

                    </div>

                    <div class="p-3">

                        <div class="movie-name">
                            <?= htmlspecialchars($m['title']) ?>
                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>
</div>
</div>

<script>
const searchInput = document.getElementById('searchInput');
const movieItems = document.querySelectorAll('.movie-item');
const suggestions = document.getElementById('suggestions');

searchInput.addEventListener('input', function () {

    const value = this.value.toLowerCase().trim();

    suggestions.innerHTML = '';

    let matches = 0;

    movieItems.forEach(movie => {

        const title = movie.dataset.title;

        if (title.includes(value)) {

            movie.style.display = '';

            if (value !== '' && matches < 6) {

                const div = document.createElement('div');

                div.className = 'suggestion-item';
                div.innerText = title;

                div.onclick = () => {
                    searchInput.value = title;
                    suggestions.style.display = 'none';
                };

                suggestions.appendChild(div);

                matches++;
            }

        } else {
            movie.style.display = 'none';
        }

    });

    suggestions.style.display =
        value !== '' && matches > 0
        ? 'block'
        : 'none';

    if (value === '') {
        movieItems.forEach(movie => {
            movie.style.display = '';
        });
    }
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-box')) {
        suggestions.style.display = 'none';
    }
});
</script>

</body>
</html>