<?php
/**
 * User Controller
 * Handles user authentication, registration, and session management
 */

session_start();
require_once __DIR__ . '/../config/database.php';

// Check database connection before proceeding
if ($pdo === false) {
    handleApiError('Database connection failed. Please check if MySQL is running.');
    exit;
}

/**
 * UserController Class
 * Manages user-related operations
 */
class UserController {
    private $pdo;

    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Register a new user
     * @param string $username
     * @param string $email
     * @param string $password
     * @return array Response with success status and message
     */
    public function register($username, $email, $password) {
        try {
            // Input validation
            $validation = $this->validateRegistrationInput($username, $email, $password);
            if (!$validation['valid']) {
                return ['success' => false, 'message' => $validation['message']];
            }

            // Check for existing user
            if ($this->userExists($username, $email)) {
                return ['success' => false, 'message' => 'Username or email already exists'];
            }

            // Hash password and insert user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = $this->insertUser($username, $email, $hashedPassword);

            return $result ?
                ['success' => true, 'message' => 'Registration successful'] :
                ['success' => false, 'message' => 'Registration failed: Database error'];

        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Registration failed: Server error'];
        }
    }

    /**
     * Authenticate user login
     * @param string $email
     * @param string $password
     * @return array Response with success status and message
     */
    public function login($email, $password) {
        try {
            // Input validation
            if (empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Email and password are required'];
            }

            // Get user from database
            $user = $this->getUserByEmail($email);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found'];
            }

            // Verify password
            if (!password_verify($password, $user['password'])) {
                return ['success' => false, 'message' => 'Invalid password'];
            }

            // Set session data
            $this->setUserSession($user['id'], $user['username']);

            return ['success' => true, 'message' => 'Login successful', 'username' => $user['username']];

        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed: Server error'];
        }
    }

    /**
     * Logout user and destroy session
     * @return array Response with success status
     */
    public function logout() {
        try {
            // Unset all session variables first
            $_SESSION = [];
            
            // Destroy the session
            session_destroy();
            
            return ['success' => true, 'message' => 'Logged out successfully'];
        } catch (Exception $e) {
            error_log("Logout error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Logout failed'];
        }
    }

    /**
     * Get current user session data
     * @return array User data or logged out status
     */
    public function getCurrentUser() {
        try {
            if (!isset($_SESSION['user_id'])) {
                return ['logged_in' => false];
            }

            // Get fresh user data from database
            $user = $this->getUserById($_SESSION['user_id']);
            if (!$user) {
                // User no longer exists, clear session
                session_destroy();
                return ['logged_in' => false];
            }

            return [
                'logged_in' => true,
                'user_id' => $user['id'],
                'username' => $user['username'],
                'is_admin' => (bool)$user['is_admin']
            ];

        } catch (Exception $e) {
            error_log("Get current user error: " . $e->getMessage());
            return ['logged_in' => false];
        }
    }

    /**
     * Validate registration input
     * @param string $username
     * @param string $email
     * @param string $password
     * @return array Validation result
     */
    private function validateRegistrationInput($username, $email, $password) {
        if (empty($username) || empty($email) || empty($password)) {
            return ['valid' => false, 'message' => 'All fields are required'];
        }

        if (strlen($username) < 3) {
            return ['valid' => false, 'message' => 'Username must be at least 3 characters long'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'message' => 'Invalid email format'];
        }

        if (strlen($password) < 6) {
            return ['valid' => false, 'message' => 'Password must be at least 6 characters long'];
        }

        return ['valid' => true];
    }

    /**
     * Check if user exists by username or email
     * @param string $username
     * @param string $email
     * @return bool
     */
    private function userExists($username, $email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Insert new user into database
     * @param string $username
     * @param string $email
     * @param string $hashedPassword
     * @return bool Success status
     */
    private function insertUser($username, $email, $hashedPassword) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword]);
    }

    /**
     * Get user by email
     * @param string $email
     * @return array|null User data or null
     */
    private function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Get user by ID
     * @param int $id
     * @return array|null User data or null
     */
    private function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT id, username, is_admin FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Set user session data
     * @param int $id
     * @param string $username
     */
    private function setUserSession($id, $username) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
    }
}

// API Request Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    $response = ['success' => false, 'message' => 'Invalid action'];

    switch ($action) {
        case 'register':
            $response = $userController->register(
                $_POST['username'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? ''
            );
            break;
        case 'login':
            $response = $userController->login(
                $_POST['email'] ?? '',
                $_POST['password'] ?? ''
            );
            break;
        case 'logout':
            $response = $userController->logout();
            break;
        case 'current_user':
            $response = $userController->getCurrentUser();
            break;
        case 'test':
            $response = ['test' => 'ok', 'method' => $_SERVER['REQUEST_METHOD']];
            break;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Handle API errors when database is unavailable
 * @param string $message Error message
 */
function handleApiError($message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $message]);
}