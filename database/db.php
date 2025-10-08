<?php

// Load environment configuration
$env = require_once __DIR__ . '/../config/env.php';
$dbConfig = require_once __DIR__ . '/../config/database.php';

// Set environment variables for database config
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

$host = $dbConfig['host'];
$username = $dbConfig['username'];
$password = $dbConfig['password'];
$database = $dbConfig['database'];
$charset = $dbConfig['charset'];

$pdo = new PDO("mysql:host=$host;dbname=$database;charset=$charset", $username, $password);

if ($pdo) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} else {
    die("Connection failed: Unable to connect to database");
}
