<?php
// Update Inspector API
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
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON payload');
    }

    $id = isset($input['id']) ? (int) $input['id'] : 0;
    $name = isset($input['name']) ? trim($input['name']) : '';
    $department = isset($input['department']) ? trim($input['department']) : '';
    $password = isset($input['password']) ? trim($input['password']) : '';

    if ($id <= 0 || $name === '' || $department === '') {
        throw new Exception('Missing required fields');
    }

    $valid_departments = ['electrical', 'mechanical', 'electronics'];
    if (!in_array($department, $valid_departments, true)) {
        throw new Exception('Invalid department');
    }

    // Ensure inspector exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ? AND role IN ('electrical','mechanical','electronics')");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        throw new Exception('Inspector not found');
    }

    if ($password !== '') {
        if (strlen($password) < 6) {
            throw new Exception('Password must be at least 6 characters long');
        }
        $stmt = $pdo->prepare("UPDATE users SET name = ?, role = ?, password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$name, $department, $password, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, role = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$name, $department, $id]);
    }

    echo json_encode(['success' => true, 'message' => 'Inspector updated successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
