<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - MovieList</title>
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

        .nav-tabs {
            border-bottom: 2px solid var(--border-color);
        }

        .nav-tabs .nav-link {
            color: var(--text-secondary);
            border: none;
            border-bottom: 2px solid transparent;
            font-weight: 600;
            padding: 1rem 2rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .nav-tabs .nav-link.active {
            background: none;
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
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
            height: 200px;
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

        .movie-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .rating-badge {
            background: linear-gradient(135deg, var(--secondary-color), #d97706);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
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

        .skeleton {
            background: linear-gradient(90deg, var(--border-color) 25%, rgba(255,255,255,0.1) 50%, var(--border-color) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-card {
            height: 300px;
            margin-bottom: 2rem;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .tab-content {
            padding-top: 2rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h4 {
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .movie-poster {
                height: 150px;
            }

            .profile-header {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<body>
    <!-- Navigation -->
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">Profile</a>
                    </li>
                </ul>
                <ul class="navbar-nav right-nav">
                    <li class="nav-item">
                        <span class="nav-link" id="userGreeting"></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logoutBtn">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="profile-header" id="profileTitle">My Movie Collection</h1>

                <!-- Profile Tabs -->
                <ul class="nav nav-tabs justify-content-center" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="watchlist-tab" data-bs-toggle="tab" data-bs-target="#watchlist" type="button" role="tab">
                            <i class="fas fa-bookmark me-2"></i>Watchlist
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="watched-tab" data-bs-toggle="tab" data-bs-target="#watched" type="button" role="tab">
                            <i class="fas fa-check-circle me-2"></i>Watched
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="watching-tab" data-bs-toggle="tab" data-bs-target="#watching" type="button" role="tab">
                            <i class="fas fa-play-circle me-2"></i>Currently Watching
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="profileTabContent">
                    <div class="tab-pane fade show active" id="watchlist" role="tabpanel">
                        <div class="row mt-4" id="watchlistContainer">
                            <!-- Watchlist movies will be loaded here -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="watched" role="tabpanel">
                        <div class="row mt-4" id="watchedContainer">
                            <!-- Watched movies will be loaded here -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="watching" role="tabpanel">
                        <div class="row mt-4" id="watchingContainer">
                            <!-- Watching movies will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        const TMDB_IMAGE_BASE_URL = 'https://image.tmdb.org/t/p/w500';

        let currentUser = null;

        $(document).ready(function() {
            checkLoginStatus();

            $('#logoutBtn').click(function(e) {
                e.preventDefault();
                logout();
            });

            $('#profileTabs button').on('shown.bs.tab', function (e) {
                const status = $(e.target).attr('data-bs-target').substring(1); // remove #
                loadUserMovies(status);
            });
        });

        function checkLoginStatus() {
            showLoadingState();
            $.get('../app/controllers/UserController.php?action=current_user', function(data) {
                if (data.logged_in) {
                    currentUser = data;
                    $('#userGreeting').html('<i class="fas fa-user-circle me-1"></i>Welcome, ' + data.username + (data.is_admin ? ' <span class="badge bg-warning text-dark">Admin</span>' : ''));
                    loadUserMovies('watchlist');
                } else {
                    window.location.href = 'index.php';
                }
            }).fail(function() {
                console.error('Failed to check login status');
                showAlert('Unable to connect to server. Redirecting...', 'warning');
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);
            });
        }

        function logout() {
            $.post('../app/controllers/UserController.php', { action: 'logout' }, function(data) {
                // Clear user credentials
                currentUser = null;
                
                // Clear any stored auth data
                localStorage.removeItem('movieListUser');
                sessionStorage.removeItem('movieListUser');
                
                showAlert('Logged out successfully', 'success');
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1000);
            }, 'json').fail(function() {
                // Even if logout fails, clear local data and redirect
                currentUser = null;
                localStorage.removeItem('movieListUser');
                sessionStorage.removeItem('movieListUser');
                
                showAlert('Logout completed. Redirecting...', 'warning');
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1000);
            });
        }

        function loadUserMovies(status) {
            showLoadingState(status);
            const statusMap = {
                'watchlist': 'want_to_watch',
                'watched': 'watched',
                'watching': 'watching'
            };

            $.get('../app/controllers/MovieController.php', {
                action: 'get_user_movies',
                status: statusMap[status]
            }, function(data) {
                if (data.success) {
                    displayUserMovies(data.movies, status);
                } else {
                    showEmptyState(status, 'Unable to load movies');
                }
            }, 'json').fail(function() {
                console.error('Failed to load user movies');
                showEmptyState(status, 'Failed to load movies. Please try again.');
            });
        }

        function displayUserMovies(movies, containerId) {
            const container = $('#' + containerId + 'Container');
            container.empty();

            if (movies.length === 0) {
                showEmptyState(containerId);
                return;
            }

            movies.forEach(movie => {
                const posterUrl = movie.poster_path ? TMDB_IMAGE_BASE_URL + movie.poster_path : 'https://via.placeholder.com/300x450/334155/94a3b8.jpg?text=No+Poster';
                const rating = movie.rating ? `<div class="rating-badge"><i class="fas fa-star"></i> ${movie.rating}</div>` : '';
                const statusText = movie.status.replace('_', ' ');
                const statusColor = getStatusColor(movie.status);

                const card = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 fade-in">
                        <div class="movie-card">
                            <img src="${posterUrl}" class="movie-poster" alt="${movie.title}" loading="lazy">
                            <div class="movie-info">
                                <h5 class="movie-title">${movie.title}</h5>
                                <p class="movie-overview">${movie.overview ? movie.overview.substring(0, 120) + '...' : 'No description available.'}</p>
                                <div class="movie-meta">
                                    <span class="status-badge" style="background: ${statusColor}">${statusText}</span>
                                    ${rating}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        function showEmptyState(containerId, message = null) {
            const container = $('#' + containerId + 'Container');
            container.empty();

            let icon, title, description;
            switch(containerId) {
                case 'watchlist':
                    icon = 'fas fa-bookmark';
                    title = 'Your watchlist is empty';
                    description = 'Start adding movies you want to watch!';
                    break;
                case 'watched':
                    icon = 'fas fa-check-circle';
                    title = 'No movies watched yet';
                    description = 'Movies you mark as watched will appear here.';
                    break;
                case 'watching':
                    icon = 'fas fa-play-circle';
                    title = 'Not watching anything right now';
                    description = 'Movies you\'re currently watching will show up here.';
                    break;
                default:
                    icon = 'fas fa-film';
                    title = 'No movies found';
                    description = message || 'Check back later for updates.';
            }

            const emptyState = `
                <div class="col-12">
                    <div class="empty-state">
                        <i class="${icon}"></i>
                        <h4>${title}</h4>
                        <p>${description}</p>
                        <a href="index.php" class="btn btn-custom">
                            <i class="fas fa-search me-1"></i>Browse Movies
                        </a>
                    </div>
                </div>
            `;
            container.append(emptyState);
        }

        function getStatusColor(status) {
            switch(status) {
                case 'want_to_watch': return 'var(--primary-color)';
                case 'watching': return 'var(--warning-color)';
                case 'watched': return 'var(--success-color)';
                default: return 'var(--text-secondary)';
            }
        }

        function showLoadingState(container = null) {
            if (container) {
                const containerEl = $('#' + container + 'Container');
                containerEl.empty();
                const skeletonHtml = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="movie-card skeleton-card">
                            <div class="skeleton" style="height: 200px; width: 100%;"></div>
                            <div class="movie-info p-3">
                                <div class="skeleton mb-2" style="height: 20px; width: 80%;"></div>
                                <div class="skeleton mb-3" style="height: 16px; width: 100%;"></div>
                                <div class="skeleton" style="height: 16px; width: 60%;"></div>
                            </div>
                        </div>
                    </div>
                `;
                containerEl.html(skeletonHtml.repeat(6));
            } else {
                // Global loading state
                const skeletonHtml = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="movie-card skeleton-card">
                            <div class="skeleton" style="height: 200px; width: 100%;"></div>
                            <div class="movie-info p-3">
                                <div class="skeleton mb-2" style="height: 20px; width: 80%;"></div>
                                <div class="skeleton mb-3" style="height: 16px; width: 100%;"></div>
                                <div class="skeleton" style="height: 16px; width: 60%;"></div>
                            </div>
                        </div>
                    </div>
                `;
                $('#watchlistContainer, #watchedContainer, #watchingContainer').html(skeletonHtml.repeat(6));
            }
        }

        function showAlert(message, type) {
            const alertClass = `alert-${type}`;
            const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;

            $('body').append(alertHtml);
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
        }
    </script>
</body>
</html>