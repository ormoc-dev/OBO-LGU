<?php
// Get latest completed Excel Import with data (columns + rows)
require_once __DIR__ . '/../../database/db.php';
require_once __DIR__ . '/../auth/auth_helper.php';

// Require authenticated session
requireAuth();

header('Content-Type: application/json');

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
    // Pagination
    $page = (int) ($_GET['page'] ?? 1);
    if ($page < 1) {
        $page = 1;
    }
    $limit = (int) ($_GET['limit'] ?? 50);
    if ($limit <= 0) {
        $limit = 50;
    }
    $offset = ($page - 1) * $limit;

    // Find latest completed import
    $stmt = $pdo->query("\n        SELECT id, filename, original_filename, total_rows, processed_rows, status, created_at\n        FROM excel_imports\n        WHERE status = 'completed'\n        ORDER BY created_at DESC\n        LIMIT 1\n    ");
    $import = $stmt->fetch();

    if (!$import) {
        sendResponse(true, 'No completed imports found', [
            'import' => null,
            'columns' => [],
            'rows' => [],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => 0,
                'total_rows' => 0,
                'per_page' => $limit,
                'has_next' => false,
                'has_prev' => false
            ]
        ]);
    }

    $importId = (int) $import['id'];

    // Columns
    $stmt = $pdo->prepare("\n        SELECT column_index, column_name, column_type, is_required\n        FROM excel_import_columns\n        WHERE import_id = ?\n        ORDER BY column_index\n    ");
    $stmt->execute([$importId]);
    $columns = $stmt->fetchAll();

    // Total rows
    $stmt = $pdo->prepare("\n        SELECT COUNT(DISTINCT row_number) AS total\n        FROM excel_import_data\n        WHERE import_id = ?\n    ");
    $stmt->execute([$importId]);
    $totalRows = (int) ($stmt->fetch()['total'] ?? 0);

    // Rows - if limit is very high (like 99999), get all data without pagination
    if ($limit >= 99999) {
        $stmt = $pdo->prepare("\n        SELECT row_number, column_name, column_value\n        FROM excel_import_data\n        WHERE import_id = ?\n        ORDER BY row_number, column_name\n    ");
        $stmt->execute([$importId]);
        $rawData = $stmt->fetchAll();
    } else {
        // Use pagination for smaller requests
        $limitInt = (int) $limit;
        $offsetInt = (int) $offset;
        $stmt = $pdo->prepare("\n        SELECT row_number, column_name, column_value\n        FROM excel_import_data\n        WHERE import_id = ?\n        ORDER BY row_number, column_name\n        LIMIT $limitInt OFFSET $offsetInt\n    ");
        $stmt->execute([$importId]);
        $rawData = $stmt->fetchAll();
    }

    // Pivot into row objects
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
    if ($currentRow !== null) {
        $rows[] = $currentRow;
    }

    $totalPages = $limitInt > 0 ? (int) ceil($totalRows / $limitInt) : 1;

    sendResponse(true, 'Latest import data retrieved', [
        'import' => $import,
        'columns' => $columns,
        'rows' => $rows,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_rows' => $totalRows,
            'per_page' => $limitInt,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ]
    ]);
} catch (Throwable $e) {
    error_log('Get latest excel data error: ' . $e->getMessage());
    sendResponse(false, 'An error occurred while retrieving latest import: ' . $e->getMessage());
}
