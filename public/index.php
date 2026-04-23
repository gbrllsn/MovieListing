<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieList - Discover Movies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --dark-bg: #0f172a;
            --darker-bg: #020617;
            --card-bg: #1e293b;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-color: #334155;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--darker-bg) 100%);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .search-container {
            position: relative;
            max-width: 400px;
            flex: 1;
            margin: 0 2rem;
        }

        .search-input {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            color: var(--text-primary);
            padding: 0.75rem 1.5rem;
            padding-right: 3rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(15, 23, 42, 0.9) 100%);
            padding: 4rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 50px 50px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .movie-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .movie-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }

        .movie-poster {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .movie-card:hover .movie-poster {
            transform: scale(1.05);
        }

        .movie-info {
            padding: 1.5rem;
        }

        .movie-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .movie-overview {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            border-color: var(--primary-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .welcome-message {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            color: var(--text-primary);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 2rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-control {
            background: var(--darker-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background: var(--darker-bg);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .genre-btn.active {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
        }

        .user-panel {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 0.55rem 1rem;
        }

        .user-panel .nav-link,
        .user-panel .user-name {
            color: white !important;
            margin: 0;
            padding: 0;
            text-decoration: none;
            white-space: nowrap;
        }

        .user-panel .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .empty-results {
            text-align: center;
            color: var(--text-secondary);
            padding: 3rem 1rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .search-container {
                margin: 1rem 0;
                max-width: none;
            }

            .movie-poster {
                height: 200px;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-film me-2"></i>
                MovieList
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Lists</a>
                    </li>
                </ul>

                <div class="search-container d-none d-md-block">
                    <input type="text" class="search-input" placeholder="Search movies..." id="searchInput">
                    <i class="fas fa-search search-icon"></i>
                </div>

                <ul class="navbar-nav right-nav" id="rightNav">
                    <li class="nav-item">
                        <button class="btn btn-custom me-2" id="loginBtn">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light" id="signupBtn" style="padding: 0.75rem 2rem;">
                            <i class="fas fa-user-plus me-1"></i>Sign Up
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section" id="guestContent">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Discover Your Next Favorite Movie</h1>
                    <p class="hero-subtitle">Explore thousands of movies, create your personal watchlist, and share your cinematic journey with fellow movie lovers.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <button class="btn btn-custom btn-lg" id="exploreBtn">
                            <i class="fas fa-compass me-2"></i>Explore Movies
                        </button>
                        <button class="btn btn-outline-light btn-lg" id="signupHeroBtn">
                            <i class="fas fa-rocket me-2"></i>Get Started
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-film fa-5x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="mb-4 text-center" id="genreFilterBar">
            <button class="btn btn-outline-warning m-1 genre-btn active" data-genre="">All</button>
            <button class="btn btn-outline-light m-1 genre-btn" data-genre="28">Action</button>
            <button class="btn btn-outline-light m-1 genre-btn" data-genre="35">Comedy</button>
            <button class="btn btn-outline-light m-1 genre-btn" data-genre="18">Drama</button>
            <button class="btn btn-outline-light m-1 genre-btn" data-genre="27">Horror</button>
            <button class="btn btn-outline-light m-1 genre-btn" data-genre="10749">Romance</button>
        </div>

        <div class="row" id="moviesContainer"></div>

        <div id="userContent" style="display: none;">
            <div class="row">
                <div class="col-12">
                    <h1 class="welcome-message" id="welcomeMessage">Welcome back!</h1>
                    <p class="text-secondary mb-4">Here's what's happening with your movie collection</p>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="dashboard-card text-center">
                                <div class="stat-number" id="watchlistCount">0</div>
                                <div class="stat-label">In Watchlist</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="dashboard-card text-center">
                                <div class="stat-number" id="watchedCount">0</div>
                                <div class="stat-label">Movies Watched</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="dashboard-card text-center">
                                <div class="stat-number" id="watchingCount">0</div>
                                <div class="stat-label">Currently Watching</div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">
                                <i class="fas fa-bookmark me-2 text-primary"></i>
                                Your Watchlist
                            </h4>
                            <a href="profile.php" class="btn btn-custom btn-sm">
                                <i class="fas fa-arrow-right me-1"></i>View All
                            </a>
                        </div>
                        <div class="row" id="watchlistPreview"></div>
                    </div>

                    <div class="dashboard-card mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">
                                <i class="fas fa-history me-2 text-success"></i>
                                Recently Watched
                            </h4>
                            <a href="profile.php#recently-watched" class="btn btn-custom btn-sm">
                                <i class="fas fa-arrow-right me-1"></i>View All
                            </a>
                        </div>
                        <div class="row" id="recentlyWatched"></div>
                    </div>

                    <div class="dashboard-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">
                                <i class="fas fa-fire me-2 text-warning"></i>
                                Trending Now
                            </h4>
                        </div>
                        <div class="row" id="popularPreview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0">
                        <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                        Welcome Back
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="loginAlert" class="alert" style="display: none;"></div>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" class="form-control" id="loginEmail" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label for="loginPassword" class="form-label">
                                <i class="fas fa-lock me-1"></i>Password
                            </label>
                            <input type="password" class="form-control" id="loginPassword" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-custom w-100" id="loginSubmitBtn">
                            <span class="loading-spinner me-2" id="loginSpinner" style="display: none;"></span>
                            <i class="fas fa-sign-in-alt me-1"></i>Sign In
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="text-secondary mb-0">Don't have an account?
                            <a href="#" id="switchToSignup" class="text-primary fw-bold">Sign up here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0">
                        <i class="fas fa-user-plus me-2 text-primary"></i>
                        Join MovieList
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="signupAlert" class="alert" style="display: none;"></div>
                    <form id="signupForm">
                        <div class="mb-3">
                            <label for="signupUsername" class="form-label">
                                <i class="fas fa-user me-1"></i>Username
                            </label>
                            <input type="text" class="form-control" id="signupUsername" placeholder="Choose a username" required>
                            <div class="form-text text-secondary">3-20 characters, letters and numbers only</div>
                        </div>
                        <div class="mb-3">
                            <label for="signupEmail" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" class="form-control" id="signupEmail" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label for="signupPassword" class="form-label">
                                <i class="fas fa-lock me-1"></i>Password
                            </label>
                            <input type="password" class="form-control" id="signupPassword" placeholder="Create a password" required>
                            <div class="form-text text-secondary">At least 6 characters long</div>
                        </div>
                        <button type="submit" class="btn btn-custom w-100" id="signupSubmitBtn">
                            <span class="loading-spinner me-2" id="signupSpinner" style="display: none;"></span>
                            <i class="fas fa-rocket me-1"></i>Get Started
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="text-secondary mb-0">Already have an account?
                            <a href="#" id="switchToLogin" class="text-primary fw-bold">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const TMDB_API_KEY = 'YOUR_TMDB_API_KEY';
        const TMDB_BASE_URL = 'https://api.themoviedb.org/3';
        const TMDB_IMAGE_BASE_URL = 'https://image.tmdb.org/t/p/w500';

        let currentUser = null;
        let selectedGenre = '';

        $(document).ready(function() {
            initializeEventHandlers();
            checkLoginStatus();
            loadPopularMovies();
        });

        function initializeEventHandlers() {
            $(document).on('click', '#loginBtn', function(e) {
                e.preventDefault();
                $('#loginAlert').hide().text('');
                $('#loginModal').modal('show');
            });

            $(document).on('click', '#signupBtn, #signupHeroBtn', function(e) {
                e.preventDefault();
                $('#signupAlert').hide().text('');
                $('#signupModal').modal('show');
            });

            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                login();
            });

            $('#signupForm').on('submit', function(e) {
                e.preventDefault();
                register();
            });

            $(document).on('click', '#switchToSignup', function(e) {
                e.preventDefault();
                $('#loginModal').modal('hide');
                setTimeout(() => $('#signupModal').modal('show'), 200);
            });

            $(document).on('click', '#switchToLogin', function(e) {
                e.preventDefault();
                $('#signupModal').modal('hide');
                setTimeout(() => $('#loginModal').modal('show'), 200);
            });

            $(document).on('click', '#logoutBtn', function(e) {
                e.preventDefault();
                logout();
            });

            $('#searchInput').on('input', function() {
                const query = $(this).val().trim();
                if (query.length > 2) {
                    searchMovies(query);
                } else if (query.length === 0) {
                    loadPopularMovies();
                }
            });

            $(document).on('click', '.add-to-watchlist', function(e) {
                e.preventDefault();
                const movieData = $(this).data('movie');
                addToWatchlist(movieData, this);
            });

            $(document).on('click', '.login-to-add-btn', function(e) {
                e.preventDefault();
                $('#loginAlert').hide().text('');
                $('#loginModal').modal('show');
            });

            $(document).on('click', '.genre-btn', function(e) {
                e.preventDefault();

                $('.genre-btn').removeClass('active btn-outline-warning').addClass('btn-outline-light');
                $(this).addClass('active');

                const genreValue = $(this).data('genre');
                if (genreValue === '') {
                    selectedGenre = '';
                    $(this).removeClass('btn-outline-light').addClass('btn-outline-warning');
                } else {
                    selectedGenre = String(genreValue);
                }

                loadPopularMovies();
            });

            $('#exploreBtn').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#genreFilterBar').offset().top - 30
                }, 500);
            });
        }

        function checkLoginStatus() {
            $.get('../app/controllers/UserController.php?action=current_user', function(data) {
                if (data.logged_in) {
                    currentUser = {
                        logged_in: true,
                        user_id: data.user_id,
                        username: data.username,
                        is_admin: data.is_admin
                    };
                    showUserContent();
                } else {
                    currentUser = null;
                    showGuestContent();
                }
                updateUI();
            }, 'json').fail(function() {
                currentUser = null;
                showGuestContent();
                updateUI();
            });
        }

        function showGuestContent() {
            $('#guestContent').show();
            $('#userContent').hide();
        }

        function showUserContent() {
            $('#guestContent').hide();
            $('#userContent').show();
            const adminText = currentUser.is_admin ? ' (Admin)' : '';
            $('#welcomeMessage').text('Welcome back, ' + currentUser.username + adminText + '!');
            loadUserDashboard();
        }

        function updateUI() {
            const rightNav = $('#rightNav');
            rightNav.empty();

            if (currentUser) {
                $('.search-container').hide();

                const adminBadge = currentUser.is_admin
                    ? '<span class="badge bg-warning text-dark">Admin</span>'
                    : '';

                rightNav.append(`
                    <li class="nav-item">
                        <div class="user-panel">
                            <a class="nav-link" href="profile.php">
                                <i class="fas fa-user me-1"></i>Profile
                            </a>
                            <a class="nav-link" href="#" id="logoutBtn">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                            <span class="user-name">
                                <i class="fas fa-user-check me-1"></i>${currentUser.username} ${adminBadge}
                            </span>
                        </div>
                    </li>
                `);
            } else {
                $('.search-container').show();

                rightNav.append(`
                    <li class="nav-item">
                        <button class="btn btn-custom me-2" id="loginBtn">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light" id="signupBtn" style="padding: 0.75rem 2rem;">
                            <i class="fas fa-user-plus me-1"></i>Sign Up
                        </button>
                    </li>
                `);
            }
        }

        function login() {
            const email = $('#loginEmail').val().trim();
            const password = $('#loginPassword').val();
            const alertBox = $('#loginAlert');

            $.post('../app/controllers/UserController.php', {
                action: 'login',
                email: email,
                password: password
            }, function(data) {
                if (data.success) {
                    $('#loginForm')[0].reset();
                    alertBox.hide().text('');
                    $('#loginModal').modal('hide');
                    checkLoginStatus();
                } else {
                    alertBox.removeClass('alert-success alert-warning').addClass('alert alert-danger').text(data.message).show();
                }
            }, 'json').fail(function() {
                alertBox.removeClass('alert-success alert-warning').addClass('alert alert-danger').text('Login failed. Please try again.').show();
            });
        }

        function register() {
            const username = $('#signupUsername').val().trim();
            const email = $('#signupEmail').val().trim();
            const password = $('#signupPassword').val();
            const alertBox = $('#signupAlert');

            $.post('../app/controllers/UserController.php', {
                action: 'register',
                username: username,
                email: email,
                password: password
            }, function(data) {
                if (data.success) {
                    $('#signupForm')[0].reset();
                    alertBox.removeClass('alert-danger alert-warning').addClass('alert alert-success').text('Registration successful! Please login.').show();
                    setTimeout(() => {
                        $('#signupModal').modal('hide');
                        $('#loginModal').modal('show');
                    }, 1200);
                } else {
                    alertBox.removeClass('alert-success alert-warning').addClass('alert alert-danger').text(data.message).show();
                }
            }, 'json').fail(function() {
                alertBox.removeClass('alert-success alert-warning').addClass('alert alert-danger').text('Registration failed. Please try again.').show();
            });
        }

        function logout() {
            $.post('../app/controllers/UserController.php', { action: 'logout' }, function() {
                currentUser = null;
                localStorage.removeItem('movieListUser');
                sessionStorage.removeItem('movieListUser');
                window.location.href = 'index.php';
            }, 'json').fail(function() {
                currentUser = null;
                localStorage.removeItem('movieListUser');
                sessionStorage.removeItem('movieListUser');
                window.location.href = 'index.php';
            });
        }

        function loadUserDashboard() {
            loadWatchlistPreview();
            loadRecentlyWatched();
            loadUserStats();
            loadPopularPreview();
        }

        function loadWatchlistPreview() {
            $.get('../app/controllers/MovieController.php', {
                action: 'get_user_movies',
                status: 'want_to_watch'
            }, function(data) {
                if (data.success) {
                    displayMoviesPreview(data.movies.slice(0, 6), 'watchlistPreview');
                }
            }, 'json');
        }

        function loadRecentlyWatched() {
            $.get('../app/controllers/MovieController.php', {
                action: 'get_user_movies',
                status: 'watched'
            }, function(data) {
                if (data.success) {
                    data.movies.sort((a, b) => new Date(b.date_watched || 0) - new Date(a.date_watched || 0));
                    displayMoviesPreview(data.movies.slice(0, 6), 'recentlyWatched');
                }
            }, 'json');
        }

        function loadUserStats() {
            $.get('../app/controllers/MovieController.php', {
                action: 'get_user_movies'
            }, function(data) {
                if (data.success) {
                    const stats = { watchlist: 0, watched: 0, watching: 0 };
                    data.movies.forEach(movie => {
                        if (movie.status === 'want_to_watch') stats.watchlist++;
                        else if (movie.status === 'watched') stats.watched++;
                        else if (movie.status === 'watching') stats.watching++;
                    });

                    $('#watchlistCount').text(stats.watchlist);
                    $('#watchedCount').text(stats.watched);
                    $('#watchingCount').text(stats.watching);
                }
            }, 'json');
        }

        function loadPopularPreview() {
            $.ajax({
                url: `${TMDB_BASE_URL}/movie/popular`,
                data: { api_key: TMDB_API_KEY },
                success: function(data) {
                    if (data.success !== false && data.results && data.results.length > 0) {
                        displayMoviesPreview(data.results.slice(0, 6), 'popularPreview');
                    } else {
                        displayMoviesPreview(getStaticMovies().slice(0, 6), 'popularPreview');
                    }
                },
                error: function() {
                    displayMoviesPreview(getStaticMovies().slice(0, 6), 'popularPreview');
                }
            });
        }

        function displayMoviesPreview(movies, containerId) {
            const container = $('#' + containerId);
            container.empty();

            if (movies.length === 0) {
                container.append('<p class="text-muted">No movies yet.</p>');
                return;
            }

            movies.forEach(movie => {
                const posterUrl = movie.poster_path
                    ? TMDB_IMAGE_BASE_URL + movie.poster_path
                    : 'https://via.placeholder.com/300x450/ff0000/ffffff.jpg?text=No+Poster';

                const card = `
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <img src="${posterUrl}" class="card-img-top" alt="${movie.title}" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <h6 class="card-title">${movie.title}</h6>
                            </div>
                        </div>
                    </div>
                `;

                container.append(card);
            });
        }

        function loadPopularMovies() {
            $.ajax({
                url: `${TMDB_BASE_URL}/movie/popular`,
                data: { api_key: TMDB_API_KEY },
                success: function(data) {
                    if (data.success !== false && data.results && data.results.length > 0) {
                        displayMovies(data.results);
                    } else {
                        displayMovies(getStaticMovies());
                    }
                },
                error: function() {
                    displayMovies(getStaticMovies());
                }
            });
        }

        function searchMovies(query) {
            $.ajax({
                url: `${TMDB_BASE_URL}/search/movie`,
                data: { api_key: TMDB_API_KEY, query: query },
                success: function(data) {
                    displayMovies(data.results || []);
                },
                error: function() {
                    displayMovies([]);
                }
            });
        }

        function displayMovies(movies) {
            const container = $('#moviesContainer');
            container.empty();

            if (selectedGenre !== '') {
                movies = movies.filter(movie =>
                    Array.isArray(movie.genre_ids) &&
                    movie.genre_ids.map(String).includes(String(selectedGenre))
                );
            }

            if (!movies.length) {
                container.html(`
                    <div class="col-12">
                        <div class="empty-results">
                            <h4>No movies found for this genre.</h4>
                        </div>
                    </div>
                `);
                return;
            }

            movies.forEach(movie => {
                const posterUrl = movie.poster_path
                    ? TMDB_IMAGE_BASE_URL + movie.poster_path
                    : 'https://via.placeholder.com/300x450/ff0000/ffffff.jpg?text=No+Poster';

                const buttonHtml = currentUser
                    ? `<button class="btn btn-primary btn-sm add-to-watchlist" data-movie='${JSON.stringify(movie)}'><i class="fas fa-bookmark me-1"></i>Add to Watchlist</button>`
                    : `<button class="btn btn-secondary btn-sm login-to-add-btn"><i class="fas fa-sign-in-alt me-1"></i>Login to Add</button>`;

                const card = `
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="${posterUrl}" class="card-img-top" alt="${movie.title}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${movie.title}</h5>
                                <p class="card-text flex-grow-1">${movie.overview ? movie.overview.substring(0, 100) + '...' : 'No description available.'}</p>
                                <div class="mt-auto d-flex align-items-center gap-2 flex-wrap">
                                    <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> ${movie.vote_average}</span>
                                    ${buttonHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                container.append(card);
            });
        }

        function addToWatchlist(movie, buttonEl) {
            if (!currentUser) {
                $('#loginModal').modal('show');
                return;
            }

            const button = buttonEl;
            button.disabled = true;
            button.innerHTML = '<span class="loading-spinner me-1"></span>Adding...';

            $.post('../app/controllers/MovieController.php', {
                action: 'add_to_watchlist',
                tmdb_id: movie.id,
                title: movie.title,
                overview: movie.overview,
                release_date: movie.release_date,
                poster_path: movie.poster_path,
                genre_ids: movie.genre_ids,
                vote_average: movie.vote_average,
                vote_count: movie.vote_count
            }, function(data) {
                if (data.success) {
                    button.innerHTML = '<i class="fas fa-check me-1"></i>Added';
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-success');
                } else {
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-bookmark me-1"></i>Add to Watchlist';
                    alert(data.message);
                }
            }, 'json').fail(function() {
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-bookmark me-1"></i>Add to Watchlist';
                alert('Failed to add to watchlist. Please try again.');
            });
        }

        function getStaticMovies() {
            return [
                {
                    id: 550,
                    title: "Fight Club",
                    overview: "A ticking-time-bomb insomniac and a slippery soap salesman channel primal male aggression into a shocking new form of therapy.",
                    vote_average: 8.4,
                    poster_path: "/pB8BM7pdSp6B6Ih7QZ4DrQ3PmJK.jpg",
                    release_date: "1999-10-15",
                    genre_ids: [18]
                },
                {
                    id: 155,
                    title: "The Dark Knight",
                    overview: "Batman raises the stakes in his war on crime. With the help of Lt. Jim Gordon and District Attorney Harvey Dent, Batman sets out to dismantle the remaining criminal organizations that plague the streets.",
                    vote_average: 9.0,
                    poster_path: "/qJ2tW6WMUDux911r6m7haRef0WH.jpg",
                    release_date: "2008-07-18",
                    genre_ids: [28, 80, 18, 53]
                },
                {
                    id: 13,
                    title: "Forrest Gump",
                    overview: "A man with a low IQ has accomplished great things in his life and been present during significant historic events.",
                    vote_average: 8.5,
                    poster_path: "/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg",
                    release_date: "1994-07-06",
                    genre_ids: [35, 18, 10749]
                },
                {
                    id: 278,
                    title: "The Shawshank Redemption",
                    overview: "Framed in the 1940s for the double murder of his wife and her lover, upstanding banker Andy Dufresne begins a new life at the Shawshank prison.",
                    vote_average: 9.3,
                    poster_path: "/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg",
                    release_date: "1994-09-23",
                    genre_ids: [18, 80]
                },
                {
                    id: 238,
                    title: "The Godfather",
                    overview: "Spanning the years 1945 to 1955, a chronicle of the fictional Italian-American Corleone crime family.",
                    vote_average: 9.2,
                    poster_path: "/3bhkrj58Vtu7enYsRolD1fZdja1.jpg",
                    release_date: "1972-03-24",
                    genre_ids: [18, 80]
                },
                {
                    id: 680,
                    title: "Pulp Fiction",
                    overview: "A burger-loving hit man, his philosophical partner, a drug-addled gangster's moll and a washed-up boxer converge in this sprawling, comedic crime caper.",
                    vote_average: 8.5,
                    poster_path: "/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg",
                    release_date: "1994-10-14",
                    genre_ids: [53, 80]
                }
            ];
        }
    </script>
</body>
</html>