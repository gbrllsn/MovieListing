<?php
require_once __DIR__ . '/../../app/config/database.php';

$username = 'test';
$email = 'test@test.com';
$password = 'test';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);
    echo "Test user created successfully. Username: test, Email: test@test.com, Password: test";
} catch(PDOException $e) {
    echo "Error creating test user: " . $e->getMessage();
}
?>