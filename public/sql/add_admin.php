<?php
require_once __DIR__ . '/../../app/config/database.php';

try {
    // Add is_admin column if it doesn't exist
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE");

    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(['admin@movielist.com']);
    if (!$stmt->fetch()) {
        // Create admin user
        $username = 'admin';
        $email = 'admin@movielist.com';
        $password = 'admin123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, TRUE)");
        $stmt->execute([$username, $email, $hashedPassword]);
        
        echo "Admin user created successfully!\n";
        echo "Username: admin\n";
        echo "Email: admin@movielist.com\n";
        echo "Password: admin123\n";
        echo "Is Admin: Yes\n";
    } else {
        echo "Admin user already exists.\n";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>