<?php
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';
Auth::gate();

require_once __DIR__ . '/../../app/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vesper — Personal Collection</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;600;700&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <style>

        .form-pane{
            display:none;
        }

        .form-pane.active{
            display:block;
        }

        .page-wrap{
            padding:3.5rem 0 5rem;
        }

        .identity-panel{
            background:rgba(14,14,18,.94);
            border:1px solid var(--border);
            border-radius:2px;
            padding:2.5rem 2rem;
            text-align:center;
        }

        .avatar-box{
            width:72px;
            height:72px;
            background:var(--accent-dim);
            border:1px solid var(--accent-border);
            margin:0 auto 1.4rem;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .avatar-box span{
            font-family:'Cormorant Garamond', serif;
            font-size:2rem;
            font-weight:600;
            color:var(--accent);
        }

        .identity-name{
            font-family:'Cormorant Garamond', serif;
            font-size:2rem;
            font-weight:600;
            letter-spacing:.08em;
            text-transform:uppercase;
        }

        .identity-rule{
            height:1px;
            background:var(--border);
            margin:1.5rem 0;
        }

        .collection-panel{
            background:rgba(14,14,18,.94);
            border:1px solid var(--border);
            overflow:hidden;
        }

        .empty-state{
            padding:3rem 2rem;
            text-align:center;
        }

        .movie-card-vesper{
            height:250px;
            overflow:hidden;
            border:1px solid var(--border);
            background:#111;
        }

        .movie-card-vesper img{
            width:100%;
            height:100%;
            object-fit:cover;
            transition:.3s;
        }

        .movie-card-vesper:hover img{
            transform:scale(1.03);
        }

        .review-item{
            padding:1rem;
            border:1px solid var(--border);
            margin-bottom:12px;
            transition:.2s;
        }

        .review-item:hover{
            background:rgba(255,255,255,.03);
            transform:translateY(-2px);
        }

        .review-title{
            font-size:10px;
            letter-spacing:.18em;
            text-transform:uppercase;
            color:var(--accent);
            margin-bottom:.7rem;
        }

        .review-text{
            font-size:.9rem;
            color:var(--text-sub);
            line-height:1.7;
            margin-bottom:.8rem;
        }

        .review-rating{
            font-size:10px;
            letter-spacing:.14em;
            text-transform:uppercase;
            color:var(--text-muted);
        }

    </style>
</head>

<body>

<div class="hero-bg"></div>
<div class="hero-vignette"></div>

<!-- NAV -->
<nav class="vesper-nav">

    <div class="inner">

        <a href="../assets/movies.php"
           class="brand-title"
           style="font-size:1.75rem;">
            VESPER
        </a>

        <div class="nav-group"
             style="display:flex; gap:12px; align-items:center;">

            <a href="../assets/movies.php"
               style="
                    text-decoration:none;
                    padding:10px 18px;
                    border:1px solid #2d4d7a;
                    background:#162133;
                    color:#8eb8ff;
                    font-size:10px;
                    letter-spacing:.18em;
                    text-transform:uppercase;
               ">
                Catalogue
            </a>

            <a href="../../app/controllers/auth/logout.php"
               class="btn-danger-vesper">
                Terminate
            </a>

        </div>

    </div>

</nav>

<!-- MAIN -->
<div class="main-content">

    <div class="container">

        <div class="page-wrap">

            <div class="row g-4">

                <!-- LEFT -->
                <div class="col-md-4 anim-1">

                    <div class="identity-panel">

                        <div class="avatar-box">

                            <span>
                                <?= strtoupper(substr($_SESSION['username'],0,1)); ?>
                            </span>

                        </div>

                        <span class="brand-label mb-2">
                            Identity
                        </span>

                        <div class="identity-name">
                            <?= htmlspecialchars($_SESSION['username']); ?>
                        </div>

                        <div class="identity-rule"></div>

                        <span class="field-label"
                              style="color:var(--text-muted); font-size:9px;">

                            Member · Vesper Cinema

                        </span>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-md-8 anim-2">

                    <div class="collection-panel">

                        <div class="auth-tabs two-col">

                            <button class="auth-tab active"
                                    onclick="switchTab('watchlist', this)">
                                Watchlist
                            </button>

                            <button class="auth-tab"
                                    onclick="switchTab('reviews', this)">
                                My Reviews
                            </button>

                        </div>

                        <!-- WATCHLIST -->
                        <div id="pane-watchlist"
                             class="form-pane active"
                             style="padding:2rem 2rem 2.5rem;">

                            <?php

                            $stmt = $pdo->prepare("
                                SELECT m.*
                                FROM movies m
                                JOIN watchlist w
                                ON m.id = w.movie_id
                                WHERE w.user_id = ?
                            ");

                            $stmt->execute([$_SESSION['user_id']]);

                            $watchlist = $stmt->fetchAll();

                            ?>

                            <?php if (!$watchlist): ?>

                                <div class="empty-state">

                                    <span class="field-label"
                                          style="opacity:.3;">

                                        No titles in watchlist

                                    </span>

                                </div>

                            <?php else: ?>

                                <div class="row g-3">

                                    <?php foreach($watchlist as $movie): ?>

                                        <?php

                                        $poster = !empty($movie['poster_path'])
                                            ? '/MovieListing/public' . $movie['poster_path']
                                            : '/MovieListing/public/assets/uploads/posters/avatar.webp';

                                        ?>

                                        <div class="col-6 col-md-4">

                                            <a href="/MovieListing/public/movie.php?id=<?= $movie['id'] ?>"
                                               style="text-decoration:none; color:inherit;">

                                                <div class="movie-card-vesper">

                                                    <img
                                                        src="<?= htmlspecialchars($poster) ?>"
                                                        alt="<?= htmlspecialchars($movie['title']) ?>">

                                                </div>

                                                <div class="p-2">

                                                    <div style="
                                                        font-size:10px;
                                                        letter-spacing:.12em;
                                                        text-transform:uppercase;
                                                        color:#fff;
                                                    ">
                                                        <?= htmlspecialchars($movie['title']) ?>
                                                    </div>

                                                </div>

                                            </a>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            <?php endif; ?>

                        </div>

                        <!-- REVIEWS -->
                        <div id="pane-reviews"
                             class="form-pane"
                             style="padding:2rem 2rem 2.5rem;">

                            <?php

                            $stmt = $pdo->prepare("
                                SELECT ur.*, m.title
                                FROM user_reviews ur
                                JOIN movies m
                                ON ur.movie_id = m.id
                                WHERE ur.user_id = ?
                                AND ur.review IS NOT NULL
                                AND ur.review != ''
                                AND ur.rating IS NOT NULL
                                ORDER BY ur.created_at DESC
                            ");

                            $stmt->execute([$_SESSION['user_id']]);

                            $reviews = $stmt->fetchAll();

                            ?>

                            <?php if (!$reviews): ?>

                                <div class="empty-state">

                                    <span class="field-label"
                                          style="opacity:.3;">

                                        No reviews published

                                    </span>

                                </div>

                            <?php else: ?>

                                <?php foreach($reviews as $rev): ?>

                                    <a href="/MovieListing/public/movie.php?id=<?= $rev['movie_id'] ?>"
                                       style="text-decoration:none; color:inherit; display:block;">

                                        <div class="review-item">

                                            <div class="review-title">
                                                <?= htmlspecialchars($rev['title']) ?>
                                            </div>

                                            <p class="review-text">
                                                <?= htmlspecialchars($rev['review']) ?>
                                            </p>

                                            <div class="review-rating">
                                                Rating:
                                                <?= htmlspecialchars($rev['rating']) ?> / 10
                                            </div>

                                            <div style="
                                                font-size:9px;
                                                color:var(--text-muted);
                                                margin-top:8px;
                                            ">

                                                Created:
                                                <?= htmlspecialchars($rev['created_at']) ?>

                                                <?php if (!empty($rev['updated_at'])): ?>

                                                    <br>

                                                    Updated:
                                                    <?= htmlspecialchars($rev['updated_at']) ?>

                                                <?php endif; ?>

                                            </div>

                                        </div>

                                    </a>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

function switchTab(tabId, btn){

    document.querySelectorAll('.auth-tab')
        .forEach(t => t.classList.remove('active'));

    document.querySelectorAll('.form-pane')
        .forEach(p => p.classList.remove('active'));

    btn.classList.add('active');

    document.getElementById('pane-' + tabId)
        .classList.add('active');
}

</script>

</body>
</html>