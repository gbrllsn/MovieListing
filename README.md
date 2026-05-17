
# <img src="https://via.placeholder.com/1200x250?text=Pampeers+Movies+Banner" alt="Pampeers Movies Banner" width="100%"/>

<h1 align="center">🎬 Pampeers Movies</h1>
<p align="center"><b>A cinematic movie discovery and tracking platform</b></p>

---

## ✨ Introduction

**Pampeers Movies** is a modular, open-source movie listing and tracking platform inspired by the Pampeers architecture. Built with **PHP (PDO)**, **MySQL**, and **Bootstrap 5**, it delivers a beautiful, modern experience for discovering, reviewing, and managing your favorite films.

---

## 🚩 Features

| Feature                | Description                                              |
|------------------------|----------------------------------------------------------|
| 🔐 Authentication      | Secure registration, login, and session management       |
| 📜 Watchlist           | Add, update, and track movies you want to watch          |
| ⭐ Ratings & Reviews    | Share your thoughts and rate movies                      |
| 🛠️ Admin Dashboard     | Manage movie listings and moderate content               |
| 🌐 TMDB API            | Fetch movie data and posters dynamically                 |

---

## 🧰 Tech Stack

<p>
  <img src="https://img.shields.io/badge/PHP-8.x-777bb4?logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white"/>
  <img src="https://img.shields.io/badge/FontAwesome-6.0-228be6?logo=fontawesome&logoColor=white"/>
  <img src="https://img.shields.io/badge/jQuery-3.6-0769AD?logo=jquery&logoColor=white"/>
</p>

---

## ⚡ Installation

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (or any LAMP stack)
- PHP 8.x
- MySQL 5.7+

### Steps
1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/pampeers-movies.git
   ```
2. **Move to XAMPP htdocs:**
   ```bash
   cp -r pampeers-movies /opt/lampp/htdocs/
   ```
3. **Database Setup:**
   - Create a MySQL database (e.g., `pampeers_movies`).
   - Import the schema:
     ```bash
     mysql -u root -p pampeers_movies < sql/schema.sql
     ```
4. **Config:**
   - Copy `app/config/config.php.example` to `app/config/config.php` (or create a `.env` file if supported).
   - Update DB credentials and TMDB API key.
5. **Run Migration:**
   - Visit `http://localhost/pampeers-movies/index.php` to auto-run migrations if implemented.
6. **Access the App:**
   - Go to `http://localhost/pampeers-movies/public/`

---

## 📂 Folder Structure

```text
├── app/
│   ├── config/         # Configuration files
│   ├── controllers/    # Modular controllers
│   │   ├── admin/      # Admin features (add/toggle movies)
│   │   ├── auth/       # Authentication (login/register/logout)
│   │   └── movies/     # Movie actions (watchlist, status)
│   ├── middleware/     # Auth/session middleware
│   └── uploads/        # Uploaded files (e.g., posters)
├── public/
│   ├── admin/          # Admin dashboard UI
│   ├── assets/         # CSS, JS, images
│   ├── index.php       # Main entry point
│   ├── movies.php      # Movie listing page
│   └── profile.php     # User profile
├── sql/
│   └── schema.sql      # Database schema
└── README.md           # Project documentation
```

**Modular Controllers:**
- `app/controllers/auth/` — User authentication
- `app/controllers/admin/` — Admin actions
- `app/controllers/movies/` — Movie endpoints
**Public Assets:**
- `public/assets/` — CSS, JS, images

---

## 🛡️ Security

- **Password Hashing:** All passwords use PHP's `password_hash()`
- **Session Middleware:** Route protection via session-based middleware
- **Prepared Statements:** All queries use PDO prepared statements

---

## 📜 License

MIT License. See [LICENSE](LICENSE).

---

<p align="center"><b>Pampeers Movies</b> — Discover, track, and share your love for cinema!</p>

The database includes tables for:
- users
- movies
- user_movies (relationships)
- lists
- list_items
- followers
- activities

## Technologies Used

- Backend: PHP with PDO
- Database: MySQL
- Frontend: HTML, CSS, Bootstrap, JavaScript, jQuery
- API: TMDB API for movie data

## File Structure

```
MovieListing/
├── app/
│   ├── config/
│   │   └── database.php
│   ├── controllers/
│   │   ├── UserController.php
│   │   └── MovieController.php
│   └── middleware/
├── public/
│   ├── index.php
│   ├── profile.php
│   └── sql/
│       ├── init.php
│       └── schema.sql
└── sql/ (empty, schema moved to public/sql/)
```

## Usage

1. Register a new account or login
2. Browse popular movies or search for specific titles
3. Click "Add to Watchlist" to add movies
4. Visit your profile to view your lists
5. Mark movies as watched or currently watching

## Security Notes

- Passwords are hashed using PHP's password_hash()
- Sessions are used for user authentication
- Input validation is implemented
- For production, consider additional security measures like CSRF protection

## Future Enhancements

- Movie ratings and reviews
- Custom lists
- Social features (following, activity feeds)
- Movie recommendations
- Admin panel
- API endpoints for mobile app