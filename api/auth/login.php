<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Start session
session_start();

// Load database connection
require_once '../../database/db.php';

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

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Method not allowed', null, 405);
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (!$input) {
        sendResponse(false, 'Invalid JSON input');
    }

    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    $remember = $input['remember'] ?? false;

    // Validate required fields
    if (empty($username) || empty($password)) {
        sendResponse(false, 'Username and password are required');
    }

    // Sanitize username
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    // Find user in database
    $stmt = $pdo->prepare("SELECT id, name, password, role, status FROM users WHERE name = ? AND status = 'active'");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        sendResponse(false, 'Invalid username or password');
    }

    // Verify password (plain text comparison)
    if ($password !== $user['password']) {
        sendResponse(false, 'Invalid username or password');
    }

    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['name'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['logged_in'] = true;

    // Set remember me cookie if requested
    if ($remember) {
        $cookieValue = base64_encode($user['id'] . ':' . hash('sha256', $user['password_hash']));
        setcookie('remember_token', $cookieValue, time() + (30 * 24 * 60 * 60), '/'); // 30 days
    }

    // Prepare user data (without sensitive information)
    $userData = [
        'id' => $user['id'],
        'name' => $user['name'],
        'role' => $user['role'],
        'status' => $user['status']
    ];

    // Determine redirect URL based on role
    $redirectUrl = getRedirectUrl($user['role']);

    sendResponse(true, 'Login successful', [
        'user' => $userData,
        'redirect_url' => $redirectUrl
    ]);
} catch (PDOException $e) {
    error_log('Database error in login: ' . $e->getMessage());
    sendResponse(false, 'Database error occurred');
} catch (Exception $e) {
    error_log('General error in login: ' . $e->getMessage());
    sendResponse(false, 'An error occurred during login');
}

// Function to determine redirect URL based on user role
function getRedirectUrl($role)
{
    switch ($role) {
        case 'systemadmin':
            return '../SystemAdmin_dashboard/Home.php';
        case 'admin':
            return '../admin_dashboard/Home.php';
        case 'electronics':
            return '../inspectors/Electronics_dashboard/Home.php';
        case 'electrical':
            return '../inspectors/Elelctrical_dashboard/Home.php';
        case 'mechanical':
            return '../inspectors/Mechanical_dashboard/Home.php';
        default:
            return '../admin_dashboard/Home.php';
    }
}
