<?php

// Load environment variables
require_once __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


try {
    // Get credentials from .env
    $dsn = 'mysql:host=' . $_ENV['DATABASE_HOSTNAME'] . ';port=' . $_ENV['PORT_NUMBER'] . ';dbname=' . $_ENV['DATABASE_NAME'];
    // Create PDO instance
    $pdo = new PDO($dsn, $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);

    // Set PDO attributes for error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
