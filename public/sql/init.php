<?php
// Connect without database first
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS movie_listing");
    $pdo->exec("USE movie_listing");

    // Read and execute schema
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    $pdo->exec($schema);

    echo "Database initialized successfully!";
} catch(PDOException $e) {
    echo "Error initializing database: " . $e->getMessage();
}
?>