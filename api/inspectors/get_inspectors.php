<?php
// Get Inspectors API
require_once '../../database/db.php';
require_once '../auth/auth_helper.php';

// Check if user is system admin
requireRole('systemadmin');

header('Content-Type: application/json');

try {
    // Get inspectors (users with role electrical, mechanical, or electronics)
    $stmt = $pdo->prepare("
        SELECT 
            id,
            name,
            role as department,
            status,
            created_at,
            updated_at
        FROM users 
        WHERE role IN ('electrical', 'mechanical', 'electronics')
        ORDER BY name ASC
    ");
    $stmt->execute();
    $inspectors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data
    $formatted_inspectors = array_map(function ($inspector) {
        return [
            'id' => (int) $inspector['id'],
            'display_id' => str_pad($inspector['id'], 3, '0', STR_PAD_LEFT),
            'name' => $inspector['name'],
            'department' => ucfirst($inspector['department']),
            'status' => $inspector['status'],
            'last_active' => $inspector['updated_at'] ?
                timeAgo($inspector['updated_at']) :
                timeAgo($inspector['created_at']),
            'created_at' => $inspector['created_at']
        ];
    }, $inspectors);

    echo json_encode([
        'success' => true,
        'data' => $formatted_inspectors
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

// Helper function to calculate time ago
function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time / 60) . ' minutes ago';
    if ($time < 86400) return floor($time / 3600) . ' hours ago';
    if ($time < 2592000) return floor($time / 86400) . ' days ago';
    if ($time < 31536000) return floor($time / 2592000) . ' months ago';
    return floor($time / 31536000) . ' years ago';
}
