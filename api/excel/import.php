<?php
// Excel Import API
require_once __DIR__ . '/../../database/db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Clear any previous output (all buffer levels)
while (ob_get_level() > 0) {
    @ob_end_clean();
}

// Increase limits for large imports (tune as needed)
@ini_set('max_execution_time', '600');
@ini_set('memory_limit', '1024M');
@ini_set('zlib.output_compression', '0');
@ini_set('output_buffering', '0');

// Simple authentication check
function requireAuth()
{
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Authentication required. Please log in again.']);
        exit;
    }
}

function getCurrentUser()
{
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

// Check if user is authenticated
requireAuth();

// Set headers before any output
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Connection: keep-alive');

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

// Suppress any error output that might interfere with JSON response
error_reporting(0);
ini_set('display_errors', 0);

// Ensure we always emit valid JSON even on fatal errors/timeouts
$__json_safe_shutdown_emitted = false;
register_shutdown_function(function () use (&$__json_safe_shutdown_emitted) {
    if ($__json_safe_shutdown_emitted) {
        return;
    }
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Server terminated while processing import',
            'data' => [
                'error_type' => $err['type'],
                'error_message' => $err['message']
            ]
        ]);
        $__json_safe_shutdown_emitted = true;
    }
});

try {
    // Only allow POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(false, 'Method not allowed', null, 405);
    }

    // Check php.ini upload limits proactively
    $postMax = ini_get('post_max_size');
    $uploadMax = ini_get('upload_max_filesize');
    $contentLen = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);

    $toBytes = function ($val) {
        $val = trim((string) $val);
        $last = strtolower(substr($val, -1));
        $num = (int) $val;
        switch ($last) {
            case 'g':
                return $num * 1024 * 1024 * 1024;
            case 'm':
                return $num * 1024 * 1024;
            case 'k':
                return $num * 1024;
            default:
                return (int) $val;
        }
    };

    if ($contentLen > 0 && ($toBytes($postMax) > 0) && $contentLen > $toBytes($postMax)) {
        sendResponse(false, 'Upload exceeds server limit (post_max_size=' . $postMax . ')');
    }
    if ($contentLen > 0 && ($toBytes($uploadMax) > 0) && $contentLen > $toBytes($uploadMax)) {
        sendResponse(false, 'Upload exceeds server limit (upload_max_filesize=' . $uploadMax . ')');
    }

    // Check if file was uploaded
    if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = 'No file uploaded';
        if (isset($_FILES['excel_file']['error'])) {
            switch ($_FILES['excel_file']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $errorMsg = 'File too large (server limit)';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $errorMsg = 'File too large (form limit)';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errorMsg = 'File upload was interrupted';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errorMsg = 'No file was uploaded';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errorMsg = 'Missing temporary folder';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errorMsg = 'Failed to write file to disk';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $errorMsg = 'File upload stopped by extension';
                    break;
                default:
                    $errorMsg = 'Unknown upload error';
                    break;
            }
        }
        sendResponse(false, $errorMsg);
    }

    $file = $_FILES['excel_file'];
    $user = getCurrentUser();

    // Validate file type
    $allowedTypes = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv'
    ];

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, ['xls', 'xlsx', 'csv'])) {
        sendResponse(false, 'Invalid file type. Please upload Excel (.xls, .xlsx) or CSV files only.');
    }

    // Validate file size (max 10MB)
    if ($file['size'] > 10 * 1024 * 1024) {
        sendResponse(false, 'File size too large. Maximum size is 10MB.');
    }

    // Create uploads directory if it doesn't exist
    $uploadDir = __DIR__ . '/../../uploads/excel/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            sendResponse(false, 'Failed to create upload directory');
        }
    }

    // Check if directory is writable
    if (!is_writable($uploadDir)) {
        sendResponse(false, 'Upload directory is not writable');
    }

    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $fileExtension;
    $filepath = $uploadDir . $filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        $error = error_get_last();
        sendResponse(false, 'Failed to save uploaded file: ' . ($error['message'] ?? 'Unknown error'));
    }

    // Start database transaction
    $pdo->beginTransaction();

    // Insert import record
    $stmt = $pdo->prepare("
        INSERT INTO excel_imports (filename, original_filename, file_size, created_by, status) 
        VALUES (?, ?, ?, ?, 'uploaded')
    ");
    $stmt->execute([$filename, $file['name'], $file['size'], $user['id']]);
    $importId = $pdo->lastInsertId();

    // Process Excel file
    $result = processExcelFile($filepath, $importId, $pdo);

    if ($result['success']) {
        $pdo->commit();
        $__json_safe_shutdown_emitted = true;
        sendResponse(true, 'Excel file imported successfully', [
            'import_id' => $importId,
            'total_rows' => $result['total_rows'],
            'columns' => $result['columns'],
            'sample_data' => $result['sample_data']
        ]);
    } else {
        $pdo->rollBack();
        // Update import status to failed
        $stmt = $pdo->prepare("UPDATE excel_imports SET status = 'failed', error_message = ? WHERE id = ?");
        $stmt->execute([$result['error'], $importId]);
        $__json_safe_shutdown_emitted = true;
        sendResponse(false, $result['error']);
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Excel import error: ' . $e->getMessage());
    $__json_safe_shutdown_emitted = true;
    sendResponse(false, 'An error occurred during import: ' . $e->getMessage());
}

function processExcelFile($filepath, $importId, $pdo)
{
    try {
        // For now, we'll handle CSV files. For Excel files, you'll need to install PhpSpreadsheet
        $fileExtension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

        if ($fileExtension === 'csv') {
            return processCsvFile($filepath, $importId, $pdo);
        } else {
            // For Excel files, you would use PhpSpreadsheet
            // This is a placeholder - you'll need to install: composer require phpoffice/phpspreadsheet
            return processExcelFileWithPhpSpreadsheet($filepath, $importId, $pdo);
        }
    } catch (Throwable $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function processCsvFile($filepath, $importId, $pdo)
{
    $handle = fopen($filepath, 'r');
    if (!$handle) {
        return ['success' => false, 'error' => 'Could not open CSV file'];
    }

    $columns = [];
    $totalRows = 0;
    $sampleData = [];
    $rowNumber = 0;

    // Read header row
    $header = fgetcsv($handle);
    if (!$header) {
        fclose($handle);
        return ['success' => false, 'error' => 'Could not read CSV header'];
    }

    // Store column information
    foreach ($header as $index => $columnName) {
        $columnName = trim($columnName);
        if (empty($columnName)) {
            $columnName = "Column_" . ($index + 1);
        }

        $columns[] = $columnName;

        $stmt = $pdo->prepare("
            INSERT INTO excel_import_columns (import_id, column_index, column_name) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$importId, $index, $columnName]);
    }

    // Read data rows
    while (($row = fgetcsv($handle)) !== false) {
        $rowNumber++;
        $totalRows++;

        // Store sample data (first 5 rows)
        if ($rowNumber <= 5) {
            $sampleRow = [];
            foreach ($header as $index => $columnName) {
                $sampleRow[$columnName] = $row[$index] ?? '';
            }
            $sampleData[] = $sampleRow;
        }

        // Store row data
        foreach ($header as $index => $columnName) {
            $columnName = trim($columnName);
            if (empty($columnName)) {
                $columnName = "Column_" . ($index + 1);
            }

            $value = $row[$index] ?? '';

            $stmt = $pdo->prepare("
                INSERT INTO excel_import_data (import_id, row_number, column_name, column_value) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$importId, $rowNumber, $columnName, $value]);
        }
    }

    fclose($handle);

    // Update import record
    $stmt = $pdo->prepare("
        UPDATE excel_imports 
        SET total_rows = ?, processed_rows = ?, status = 'completed' 
        WHERE id = ?
    ");
    $stmt->execute([$totalRows, $totalRows, $importId]);

    return [
        'success' => true,
        'total_rows' => $totalRows,
        'columns' => $columns,
        'sample_data' => $sampleData
    ];
}

function processExcelFileWithPhpSpreadsheet($filepath, $importId, $pdo)
{
    try {
        // Include Composer autoloader
        require_once __DIR__ . '/../../vendor/autoload.php';

        // Load the Excel file
        if (!extension_loaded('zip')) {
            return ['success' => false, 'error' => 'PHP Zip extension is required to read XLSX files. Please enable ext-zip in php.ini.'];
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filepath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filepath);

        // Get the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        if ($highestRow < 2) {
            return ['success' => false, 'error' => 'Excel file appears to be empty or has no data rows'];
        }

        $columns = [];
        $totalRows = 0;
        $sampleData = [];

        // Read header row (first row)
        $headerRow = $worksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
        $header = array_values($headerRow[1]); // Normalize to numeric indices (0-based)

        // Store column information
        foreach ($header as $index => $columnName) {
            $columnName = trim($columnName);
            if (empty($columnName)) {
                $columnName = "Column_" . ($index + 1);
            }

            $columns[] = $columnName;

            $stmt = $pdo->prepare("
                INSERT INTO excel_import_columns (import_id, column_index, column_name) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$importId, $index, $columnName]);
        }

        // Read data rows (starting from row 2)
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
            $rowValues = array_values($rowData[$row]); // Normalize to numeric indices like header

            // Skip completely empty rows
            $hasData = false;
            foreach ($rowValues as $value) {
                if (!empty(trim($value))) {
                    $hasData = true;
                    break;
                }
            }
            
            if (!$hasData) {
                continue; // Skip empty rows
            }

            $totalRows++;

            // Store sample data (first 5 rows)
            if ($totalRows <= 5) {
                $sampleData[] = array_values($rowValues);
            }

            // Store each column value separately in database
            foreach ($rowValues as $columnIndex => $value) {
                $columnName = $columns[$columnIndex] ?? "Column_" . ($columnIndex + 1);
                $stmt = $pdo->prepare("
                    INSERT INTO excel_import_data (import_id, row_number, column_name, column_value) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$importId, $totalRows, $columnName, $value]);
            }
        }

        // Update import record with success status (align with CSV path schema)
        $stmt = $pdo->prepare("
            UPDATE excel_imports 
            SET total_rows = ?, processed_rows = ?, status = 'completed' 
            WHERE id = ?
        ");
        $stmt->execute([$totalRows, $totalRows, $importId]);

        return [
            'success' => true,
            'total_rows' => $totalRows,
            'columns' => $columns,
            'sample_data' => $sampleData
        ];
    } catch (Throwable $e) {
        error_log('Excel processing error: ' . $e->getMessage());
        return [
            'success' => false,
            'error' => 'Failed to process Excel file: ' . $e->getMessage()
        ];
    }
}
