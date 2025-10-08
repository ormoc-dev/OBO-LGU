<?php
// Start session
session_start();

try {
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

    // Redirect to login page
    header('Location: ../../index.php');
    exit;
} catch (Exception $e) {
    error_log('Error in logout: ' . $e->getMessage());
    // Even if there's an error, redirect to login page
    header('Location: ../../index.php');
    exit;
}
