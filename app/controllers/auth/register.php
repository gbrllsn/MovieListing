<?php
require_once __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../../public/assets/index.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($password)) {
    header('Location: ../../../public/assets/index.php?error=empty_fields');
    exit();
}

try {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    header('Location: ../../../public/assets/index.php?registration=success');
} catch (PDOException $e) {
    header('Location: ../../../public/assets/index.php?error=email_exists');
}
?>