<?php
// Get Excel Import Data API
require_once __DIR__ . '/../../database/db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Simple authentication check
function requireAuth()
{
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Authentication required']);
        exit;
    }
}

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
    // Get import ID from query parameter
    $importId = $_GET['import_id'] ?? null;

    if (!$importId) {
        sendResponse(false, 'Import ID is required');
    }

    // Validate import ID
    $importId = (int) $importId;
    if ($importId <= 0) {
        sendResponse(false, 'Invalid import ID');
    }

    // Get import information
    $stmt = $pdo->prepare("
        SELECT id, filename, original_filename, total_rows, processed_rows, status, created_at
        FROM excel_imports 
        WHERE id = ?
    ");
    $stmt->execute([$importId]);
    $import = $stmt->fetch();

    if (!$import) {
        sendResponse(false, 'Import not found');
    }

    // Get column structure
    $stmt = $pdo->prepare("
        SELECT column_index, column_name, column_type, is_required
        FROM excel_import_columns 
        WHERE import_id = ? 
        ORDER BY column_index
    ");
    $stmt->execute([$importId]);
    $columns = $stmt->fetchAll();

    // Get pagination parameters
    $page = (int) ($_GET['page'] ?? 1);
    if ($page < 1) {
        $page = 1;
    }
    $limit = (int) ($_GET['limit'] ?? 50);
    if ($limit <= 0) {
        $limit = 50;
    }
    $offset = ($page - 1) * $limit;

    // Get total count
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT row_number) as total 
        FROM excel_import_data 
        WHERE import_id = ?
    ");
    $stmt->execute([$importId]);
    $totalRows = $stmt->fetch()['total'];

    // Get data rows - if limit is very high (like 99999), get all data without pagination
    if ($limit >= 99999) {
        $stmt = $pdo->prepare("
            SELECT row_number, column_name, column_value
            FROM excel_import_data 
            WHERE import_id = ? 
            ORDER BY row_number, column_name
        ");
        $stmt->execute([$importId]);
        $rawData = $stmt->fetchAll();
    } else {
        // Use pagination for smaller requests
        $limitInt = (int) $limit;
        $offsetInt = (int) $offset;
        $stmt = $pdo->prepare("
            SELECT row_number, column_name, column_value
            FROM excel_import_data 
            WHERE import_id = ? 
            ORDER BY row_number, column_name
            LIMIT $limitInt OFFSET $offsetInt
        ");
        $stmt->execute([$importId]);
        $rawData = $stmt->fetchAll();
    }

    // Transform data into rows
    $rows = [];
    $currentRow = null;
    $currentRowNumber = null;

    foreach ($rawData as $item) {
        if ($currentRowNumber !== $item['row_number']) {
            if ($currentRow !== null) {
                $rows[] = $currentRow;
            }
            $currentRow = ['_row_number' => $item['row_number']];
            $currentRowNumber = $item['row_number'];
        }
        $currentRow[$item['column_name']] = $item['column_value'];
    }

    // Add the last row
    if ($currentRow !== null) {
        $rows[] = $currentRow;
    }

    // Calculate pagination info
    $totalPages = ceil($totalRows / $limit);

    sendResponse(true, 'Data retrieved successfully', [
        'import' => $import,
        'columns' => $columns,
        'rows' => $rows,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_rows' => $totalRows,
            'per_page' => $limit,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ]
    ]);
} catch (Exception $e) {
    error_log('Get Excel data error: ' . $e->getMessage());
    sendResponse(false, 'An error occurred while retrieving data: ' . $e->getMessage());
}
