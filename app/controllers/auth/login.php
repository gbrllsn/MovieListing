<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Corrected path to go back to the root index.php
    header('Location: ../../../index.php'); 
    exit();
}

// 1. Change 'email' to 'identifier' to match your index.php form
$identifier = trim($_POST['identifier'] ?? ''); 
$password = $_POST['password'] ?? '';

try {
    // 2. Search for either the username OR the email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = (bool)$user['is_admin'];

        // Redirect based on role
        if ($_SESSION['is_admin']) {
            header('Location: ../../../public/admin/admin.php');
        } else {
            header('Location: ../../../public/assets/movies.php?login=success');
        }
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}