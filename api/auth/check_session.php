<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Start session
session_start();

// Load database connection
require_once '../../database/db.php';

// Function to send JSON response
function sendResponse($success, $message, $data = null, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

try {
    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        sendResponse(false, 'Not logged in', null, 401);
    }
    
    // Get user data from session
    $userData = [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
    
    // Verify user still exists and is active
    if ($userData['id']) {
        $stmt = $pdo->prepare("SELECT id, name, role, status FROM users WHERE id = ? AND status = 'active'");
        $stmt->execute([$userData['id']]);
        $user = $stmt->fetch();
        
        if (!$user) {
            // User no longer exists or is inactive, destroy session
            session_destroy();
            sendResponse(false, 'User account not found or inactive', null, 401);
        }
        
        // Update session with current user data
        $userData = [
            'id' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role'],
            'status' => $user['status']
        ];
    }
    
    sendResponse(true, 'Session valid', [
        'user' => $userData,
        'logged_in' => true
    ]);
    
} catch (PDOException $e) {
    error_log('Database error in check_session: ' . $e->getMessage());
    sendResponse(false, 'Database error occurred');
} catch (Exception $e) {
    error_log('General error in check_session: ' . $e->getMessage());
    sendResponse(false, 'An error occurred');
}
?>
