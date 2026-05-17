<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vesper Security Middleware
 */
class Auth {
    public static function gate() {
        if (!isset($_SESSION['user_id'])) {
            // If not logged in, send to landing
            header("Location: index.php"); 
            exit();
        }
    }

    public static function adminOnly() {
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            header("Location: movies.php?error=unauthorized");
            exit();
        }
    }
}