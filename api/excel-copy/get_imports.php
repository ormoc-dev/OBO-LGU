<?php
// Get Excel Imports List API
require_once __DIR__ . '/../../database/db.php';
require_once __DIR__ . '/../auth/auth_helper.php';

// Check if user is authenticated
requireAuth();

header('Content-Type: application/json');

// Function to send JSON response
function sendResponse($success, $message, $data = null, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

try {
    // Get pagination parameters
    $page = (int) ($_GET['page'] ?? 1);
    if ($page < 1) {
        $page = 1;
    }
    $limit = (int) ($_GET['limit'] ?? 20);
    if ($limit <= 0) {
        $limit = 20;
    }
    $offset = ($page - 1) * $limit;

    // Get total count
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM excel_imports");
    $stmt->execute();
    $totalImports = $stmt->fetch()['total'];

    // Get imports with user information (avoid placeholders for LIMIT/OFFSET)
    $limitInt = (int) $limit;
    $offsetInt = (int) $offset;
    $sql = "
        SELECT 
            ei.id,
            ei.filename,
            ei.original_filename,
            ei.file_size,
            ei.total_rows,
            ei.processed_rows,
            ei.status,
            ei.error_message,
            ei.created_at,
            ei.updated_at,
            u.name as created_by_name
        FROM excel_imports ei
        LEFT JOIN users u ON ei.created_by = u.id
        ORDER BY ei.created_at DESC
        LIMIT $limitInt OFFSET $offsetInt
    ";
    $stmt = $pdo->query($sql);
    $imports = $stmt->fetchAll();

    // Format file sizes
    foreach ($imports as &$import) {
        $import['file_size_formatted'] = formatFileSize($import['file_size']);
        $import['created_at_formatted'] = date('M j, Y g:i A', strtotime($import['created_at']));
    }

    // Calculate pagination info
    $totalPages = ceil($totalImports / $limit);

    sendResponse(true, 'Imports retrieved successfully', [
        'imports' => $imports,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_imports' => $totalImports,
            'per_page' => $limit,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ]
    ]);
} catch (Exception $e) {
    error_log('Get imports error: ' . $e->getMessage());
    sendResponse(false, 'An error occurred while retrieving imports: ' . $e->getMessage());
}

function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
