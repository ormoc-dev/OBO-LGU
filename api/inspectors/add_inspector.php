<?php
// Add New Inspector API
require_once '../../database/db.php';
require_once '../auth/auth_helper.php';

// Check if user is system admin
requireRole('systemadmin');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get POST data
    $raw_input = file_get_contents('php://input');
    $input = json_decode($raw_input, true);

    // Debug: Log everything
    error_log("Raw input: " . $raw_input);
    error_log("Decoded data: " . print_r($input, true));
    error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

    // Check if input is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON data: " . json_last_error_msg());
    }

    // Validate required fields
    $required_fields = ['name', 'department', 'password'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Field '{$field}' is required. Received: " . print_r($input, true));
        }
    }

    $name = trim($input['name']);
    $department = trim($input['department']);
    $password = trim($input['password']);

    // Validate department
    $valid_departments = ['electrical', 'mechanical', 'electronics'];
    if (!in_array($department, $valid_departments)) {
        throw new Exception("Invalid department. Must be one of: " . implode(', ', $valid_departments));
    }

    // Validate password strength
    if (strlen($password) < 6) {
        throw new Exception("Password must be at least 6 characters long");
    }

    // Check if inspector with same name already exists
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE name = ? AND role IN ('electrical', 'mechanical', 'electronics')");
    $stmt->execute([$name]);
    $existing_inspector = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($existing_inspector) {
        throw new Exception("An inspector with the name '{$name}' already exists in the {$existing_inspector['role']} department. Please choose a different name.");
    }

    // Insert new inspector (password stored as plain text)
    $stmt = $pdo->prepare("
        INSERT INTO users (name, password, role, status, created_at) 
        VALUES (?, ?, ?, 'active', NOW())
    ");

    $result = $stmt->execute([$name, $password, $department]);

    // Debug: Log the insert result
    error_log("Insert result: " . ($result ? 'true' : 'false'));
    error_log("Insert data: name=$name, password=$password, department=$department");

    if ($result) {
        $inspector_id = $pdo->lastInsertId();
        error_log("Inserted ID: " . $inspector_id);

        // Get the created inspector data
        $stmt = $pdo->prepare("
            SELECT id, name, role, status, created_at 
            FROM users 
            WHERE id = ?
        ");
        $stmt->execute([$inspector_id]);
        $inspector = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Check if inspector was actually inserted
        if (!$inspector) {
            throw new Exception("Inspector was inserted but could not be retrieved");
        }

        echo json_encode([
            'success' => true,
            'message' => 'Inspector added successfully',
            'data' => $inspector,
            'debug' => [
                'inserted_id' => $inspector_id,
                'name' => $name,
                'department' => $department
            ]
        ]);
    } else {
        throw new Exception("Failed to add inspector - execute() returned false");
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
