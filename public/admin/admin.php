<?php
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';
Auth::gate();
require_once __DIR__ . '/../../app/config/config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: /MovieListing/public/assets/movies.php');
    exit();
}

try {
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $movieCount = $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
    $reviewCount = $pdo->query("SELECT COUNT(*) FROM user_reviews WHERE review IS NOT NULL AND review != ''")->fetchColumn();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vesper — Command Center</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">

<style>
body {
    background-color: #08080a;
    color: #fff;
    font-family: 'Outfit', sans-serif;
    overflow-x: hidden;
}

/* NAV */
.admin-nav {
    background: rgba(0,0,0,0.4);
    border-bottom: 1px solid var(--border);
    backdrop-filter: blur(8px);
}

/* MAIN WRAP */
.admin-dashboard {
    padding-top: 120px;
    max-width: 1100px;
    margin: auto;
    position: relative;
    z-index: 2;
}

/* PANEL */
.auth-panel {
    background: rgba(255,255,255,0.02);
    border: 1px solid var(--border);
    backdrop-filter: blur(10px);
    overflow: hidden;
}

/* TABS */
.auth-tabs {
    display: flex;
    border-bottom: 1px solid var(--border);
    background: rgba(0,0,0,0.3);
}

.auth-tab {
    flex: 1;
    padding: 1rem;
    background: transparent;
    border: none;
    color: #aaa;
    cursor: pointer;
}

.auth-tab.active {
    color: var(--accent);
    border-bottom: 2px solid var(--accent);
}

/* PANES */
.form-pane {
    display: none;
    padding: 0;
}

.form-pane.active {
    display: block;
}

/* FIX: SCROLLABLE CONTENT */
.scroll-area {
    max-height: 65vh;
    overflow-y: auto;
    padding: 1rem;
}

/* TABLE FIX */
.vesper-table {
    width: 100%;
    background: transparent !important;
    color: white;
}

.vesper-table td,
.vesper-table th {
    background: transparent !important;
    color: white !important;
    border-bottom: 1px solid var(--border);
}

/* LOGOUT */
.btn-logout-vesper {
    background: transparent;
    border: none;
    color: #ff4d4d;
    font-size: 10px;
    letter-spacing: 0.12em;
    padding: 6px 10px;
    text-decoration: none;
}

.btn-logout-vesper:hover {
    color: #ff4d4d;
    opacity: 0.7;
}
</style>
</head>

<body>

<div class="hero-bg"></div>
<div class="hero-vignette"></div>

<!-- NAV -->
<nav class="navbar admin-nav fixed-top py-4">
    <div class="container-fluid px-5 d-flex justify-content-between align-items-center">

        <a href="/MovieListing/public/assets/movies.php"
           class="brand-title text-decoration-none"
           style="font-size: 1.8rem; margin: 0; color: #fff;">
            VESPER
        </a>

        <div class="d-flex align-items-center">

            <a href="/MovieListing/public/assets/profile.php"
                style="
                text-decoration:none;
                padding:10px 18px;
                border:1px solid #6b5d1e;
                background:#2b2411;
                color:#ffd76a;
                font-size:10px;
                letter-spacing:0.18em;
                text-transform:uppercase;
                margin-right:12px;
                ">
                ADMIN: <?= htmlspecialchars($_SESSION['username']) ?>
            </a>

            <a href="../../app/controllers/auth/logout.php" class="btn-danger-vesper">
                TERMINATE
            </a>

        </div>
    </div>
</nav>

<!-- MAIN -->
<div class="admin-dashboard container">

    <div class="mb-4">
        <span style="color:#888;">Management Suite</span>
        <h1 style="font-size:2.5rem;">SYSTEM COMMAND</h1>
    </div>

    <div class="auth-panel">

        <div class="admin-search mb-4">
            <input
                type="text"
                id="adminSearch"
                class="field-input"
                placeholder="Search movies, users, reviews..."
                onkeyup="adminSearch()"
            >
        </div>

        <!-- TABS -->
        <div class="auth-tabs">
            <button class="auth-tab active" onclick="switchTab('catalog', this)">Catalog</button>
            <button class="auth-tab" onclick="switchTab('reviews', this)">Reviews</button>
            <button class="auth-tab" onclick="switchTab('registry', this)">Users</button>
        </div>

        <!-- CATALOG -->
        <div id="pane-catalog" class="form-pane active">
            <div class="p-4 d-flex justify-content-between align-items-center">
                <span class="brand-label">Global Index</span>

                <button onclick="window.location.href='addMovie.php'"
                        style="
                        border:none;
                        background:#2563eb;
                        color:white;
                        padding:10px 18px;
                        font-size:10px;
                        letter-spacing:0.18em;
                        text-transform:uppercase;
                        ">
                    + Add Movie
                </button>
            </div>

            <div class="scroll-area">
                <h6 style="color:#888;">Movies</h6>

                <table class="vesper-table table table-borderless">
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM movies ORDER BY id DESC");
                        while($m = $stmt->fetch()): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($m['title']) ?>
                            </td>

                            <td class="text-end">
                                <a href="editMovie.php?id=<?= $m['id'] ?>" class="btn-accent-vesper">
                                    EDIT
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- REVIEWS -->
        <div id="pane-reviews" class="form-pane">
            <div class="scroll-area">
                <table class="vesper-table table table-borderless">
                    <tbody>
                        <?php
                        $stmt = $pdo->query("
                            SELECT ur.*, u.username, m.title
                            FROM user_reviews ur
                            JOIN users u ON ur.user_id = u.id
                            JOIN movies m ON ur.movie_id = m.id
                        ");
                        while($r = $stmt->fetch()): ?>
                        <tr class="review-row">
                            <td style="width:20%;">
                                <div style="font-size:11px; color:#fff;">
                                    <?= htmlspecialchars($r['username']) ?>
                                </div>
                            </td>

                            <td style="width:25%;">
                                <div style="font-size:10px; color:#8eb8ff; text-transform:uppercase; letter-spacing:0.08em;">
                                    <?= htmlspecialchars($r['title']) ?>
                                </div>
                            </td>

                            <td style="width:10%; color:#ffd76a;">
                                ★ <?= $r['rating'] ?>
                            </td>

                            <td style="color:#bbb;">
                                <?= htmlspecialchars(substr($r['review'],0,90)) ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- USERS -->
        <div id="pane-registry" class="form-pane">
            <div class="scroll-area">
                <table class="vesper-table table table-borderless">
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
                        while($u = $stmt->fetch()): ?>
                        <tr>
                            <td>
                                <div style="font-size:11px; color:#fff; letter-spacing:0.08em;">
                                    <?= htmlspecialchars($u['username']) ?>
                                </div>

                                <div style="font-size:9px; color:#777; margin-top:3px;">
                                    ID: <?= $u['id'] ?>
                                </div>
                            </td>

                            <td style="color:#aaa;">
                                <?= htmlspecialchars($u['email']) ?>
                            </td>

                            <td style="text-align:right;">
                                <?php if($u['is_admin']): ?>
                                    <span style="
                                        color:#ffd76a;
                                        font-size:10px;
                                        letter-spacing:0.12em;
                                        text-transform:uppercase;
                                    ">
                                        ADMIN
                                    </span>
                                <?php else: ?>
                                    <span style="
                                        color:#4ade80;
                                        font-size:10px;
                                        letter-spacing:0.12em;
                                        text-transform:uppercase;
                                    ">
                                        MEMBER
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
function switchTab(id, btn){
    document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.form-pane').forEach(p => p.classList.remove('active'));

    btn.classList.add('active');
    document.getElementById('pane-' + id).classList.add('active');
}
</script>

<script>
function adminSearch() {

    let input = document.getElementById("adminSearch").value.toLowerCase();

    document.querySelectorAll("tbody tr").forEach(row => {

        let text = row.innerText.toLowerCase();

        if(text.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });
}

function switchTab(id, btn){
    document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.form-pane').forEach(p => p.classList.remove('active'));

    btn.classList.add('active');
    document.getElementById('pane-' + id).classList.add('active');
}
</script>

</body>
</html>