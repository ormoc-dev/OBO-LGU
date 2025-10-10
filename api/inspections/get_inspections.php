<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../auth/auth_helper.php';
require_once 'InspectionManager.php';

// Start session
session_start();

// Check if user is logged in
requireLogin();

// Get current user
$user = getCurrentUser();
if (!$user) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

try {
    $inspectionManager = new InspectionManager();
    
    // Get query parameters
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $status = $_GET['status'] ?? null;
    
    // Get inspections
    $inspections = $inspectionManager->getInspectionsByInspector($user['id'], $limit, $offset);
    
    // Get statistics
    $stats = $inspectionManager->getStatistics($user['id']);
    
    echo json_encode([
        'success' => true,
        'data' => [
            'inspections' => $inspections,
            'statistics' => $stats
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
