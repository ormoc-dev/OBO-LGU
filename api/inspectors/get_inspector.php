<?php
// Get Single Inspector API
require_once '../../database/db.php';
require_once '../auth/auth_helper.php';

// Check if user is system admin
requireRole('admin');

header('Content-Type: application/json');

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid or missing inspector ID']);
        exit;
    }

    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT id, name, role as department, status, created_at, updated_at FROM users WHERE id = ? AND role IN ('electrical/electronics','mechanical','civil/structural','architectural','line/grade','sanitary/plumbing')");
    $stmt->execute([$id]);
    $inspector = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inspector) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Inspector not found']);
        exit;
    }

    $inspector['department'] = ucfirst($inspector['department']);

    echo json_encode([
        'success' => true,
        'data' => $inspector
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
