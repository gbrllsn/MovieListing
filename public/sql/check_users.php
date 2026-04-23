<?php
require_once __DIR__ . '/../../app/config/database.php';

try {
    $stmt = $pdo->query("SELECT id, username, email FROM users");
    $users = $stmt->fetchAll();
    echo "Users in database:\n";
    foreach ($users as $user) {
        echo "ID: {$user['id']}, Username: {$user['username']}, Email: {$user['email']}\n";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>