# MovieList - Movie Listing Website

A full-stack movie listing website inspired by Letterboxd, built with PHP, MySQL, and Bootstrap.

## Features

- User registration and login
- Browse popular movies from TMDB API
- Search movies
- Add movies to watchlist
- Mark movies as watched/watching
- User profiles with movie lists
- Responsive design

## Setup Instructions

1. **Prerequisites:**
   - XAMPP (or any PHP/MySQL environment)
   - TMDB API key (get from https://www.themoviedb.org/settings/api)

2. **Installation:**
   - Clone or download the project to `c:\xampp\htdocs\MovieListing`
   - Start XAMPP (Apache and MySQL)
   - Run the database setup: Open `http://localhost/MovieListing/public/sql/init.php` in browser or run via command line
   - Run admin setup: Open `http://localhost/MovieListing/public/sql/add_admin.php` in browser or run via command line

3. **Configuration:**
   - Get TMDB API key from https://www.themoviedb.org/settings/api
   - Edit `public/index.php` and replace `YOUR_TMDB_API_KEY` with your actual key

4. **Access the site:**
   - Open `http://localhost/MovieListing/public/index.php` in your browser

## User Accounts

- **Test User:** email `test@test.com`, password `test`
- **Admin User:** email `admin@movielist.com`, password `admin123`

## Database Schema

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