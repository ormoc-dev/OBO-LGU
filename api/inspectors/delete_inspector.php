<?php
// Delete Inspector API
require_once '../../database/db.php';
require_once '../auth/auth_helper.php';

// Check if user is system admin
requireRole('admin');

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
    if ($id <= 0) {
        throw new Exception('Invalid inspector ID');
    }

    // Ensure inspector exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ? AND role IN ('electrical/electronics','mechanical','civil/structural','architectural','line/grade','sanitary/plumbing')");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        throw new Exception('Inspector not found');
    }

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Inspector deleted successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>

