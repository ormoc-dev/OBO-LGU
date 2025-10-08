<?php
// Dashboard metrics API
require_once '../../database/db.php';
require_once '../auth/auth_helper.php';

// Require system admin
requireRole('systemadmin');

header('Content-Type: application/json');

try {
    // Total users
    $totalUsers = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role IN ('electrical', 'mechanical', 'electronics')")->fetchColumn();

    // Other metrics (placeholders unless corresponding tables exist)
    // If you add tables, replace queries accordingly.
    $activeInspections = 0;
    $completedReports = 0;
    $pendingApprovals = 0;

    echo json_encode([
        'success' => true,
        'data' => [
            'total_users' => $totalUsers,
            'active_inspections' => $activeInspections,
            'completed_reports' => $completedReports,
            'pending_approvals' => $pendingApprovals
        ]
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>

