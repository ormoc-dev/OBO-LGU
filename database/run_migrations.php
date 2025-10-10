<?php
/**
 * Database Migration Runner
 * Run this script to apply all database migrations
 */

require_once 'db.php';

function runMigration($filename) {
    global $pdo;
    
    echo "Running migration: {$filename}\n";
    
    $sql = file_get_contents($filename);
    if ($sql === false) {
        throw new Exception("Could not read migration file: {$filename}");
    }
    
    // Split SQL into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) { return !empty($stmt); }
    );
    
    foreach ($statements as $statement) {
        if (!empty(trim($statement))) {
            try {
                $pdo->exec($statement);
                echo "✓ Executed: " . substr($statement, 0, 50) . "...\n";
            } catch (PDOException $e) {
                echo "✗ Error: " . $e->getMessage() . "\n";
                echo "Statement: " . substr($statement, 0, 100) . "...\n";
                throw $e;
            }
        }
    }
    
    echo "✓ Migration completed: {$filename}\n\n";
}

try {
    echo "Starting database migrations...\n\n";
    
    // Run migrations in order
    $migrations = [
        'migrations/001_create_users_table.sql',
        'migrations/002_create_inspections_table.sql'
    ];
    
    foreach ($migrations as $migration) {
        if (file_exists($migration)) {
            runMigration($migration);
        } else {
            echo "⚠ Warning: Migration file not found: {$migration}\n";
        }
    }
    
    echo "🎉 All migrations completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
