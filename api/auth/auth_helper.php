<?php
// Authentication helper functions

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Load database connection
require_once __DIR__ . '/../../database/db.php';

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Get current user data
 */
function getCurrentUser()
{
    if (!isLoggedIn()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

/**
 * Check if user has specific role
 */
function hasRole($role)
{
    $user = getCurrentUser();
    return $user && $user['role'] === $role;
}

/**
 * Check if user has any of the specified roles
 */
function hasAnyRole($roles)
{
    $user = getCurrentUser();
    return $user && in_array($user['role'], $roles);
}

/**
 * Require login - redirect to login page if not logged in
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: ../../view/auth/Login.php');
        exit;
    }
}

/**
 * Require specific role - redirect to login if not logged in or wrong role
 */
function requireRole($role)
{
    requireLogin();

    if (!hasRole($role)) {
        header('Location: ../../index.php');
        exit;
    }
}

/**
 * Require any of the specified roles
 */
function requireAnyRole($roles)
{
    requireLogin();

    if (!hasAnyRole($roles)) {
        header('Location: /OBO-LGU/index.php');
        exit;
    }
}

/**
 * Get redirect URL based on user role
 */
function getDashboardUrl($role)
{
    switch ($role)
     {
        case 'civil/structural':
            return '/OBO-LGU/view/Civil&Structural/Home.php';
        case 'electrical/electronics':
            return '/OBO-LGU/view/Electrical&Electronics/Home.php';
        case 'architectural':
            return '/OBO-LGU/view/Architectural/Home.php';
        case 'mechanical':
            return '/OBO-LGU/view/inspectors/Mechanical_dashboard/Home.php';
        case 'line/grade':
            return '/OBO-LGU/view/inspectors/Line&Grade_dashboard/Home.php';
        case 'sanitary/plumbing':
            return '/OBO-LGU/view/inspectors/Sanitary&Plumbing_dashboard/Home.php';
        default:
            return '/OBO-LGU/view/Admin/Home.php';
    }
}

/**
 * Require login for API endpoints and return JSON 401 instead of redirecting
 */
function requireAuth()
{
    if (!isLoggedIn()) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Authentication required']);
        exit;
    }
}

/**
 * Logout user
 */
function logout()
{
    // Clear session variables
    $_SESSION = array();

    // Destroy session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Clear remember me cookie
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }
}

/**
 * Validate user session against database
 */
function validateSession()
{
    if (!isLoggedIn()) {
        return false;
    }

    try {
        global $pdo;
        $userId = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT id, name, role, status FROM users WHERE id = ? AND status = 'active'");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user) {
            logout();
            return false;
        }

        // Update session with current user data
        $_SESSION['username'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        return true;
    } catch (PDOException $e) {
        error_log('Database error in validateSession: ' . $e->getMessage());
        return false;
    }
}
