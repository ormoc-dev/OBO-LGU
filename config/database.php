<?php

// Database Configuration
return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'username' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
    'database' => $_ENV['DB_NAME'] ?? 'lgu_annual_inspection',
    'charset' => $_ENV['DB_CHARSET'] ?? 'utf8'
];
