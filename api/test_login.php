<?php
// Simple test script to verify login API works
// This is for testing purposes only - remove in production

header('Content-Type: application/json');

// Test data
$testData = [
    'username' => 'System Administrator',
    'password' => 'admin123',
    'remember' => false
];

// Make request to login API
$url = 'http://localhost/lgu_annual_inspection/api/auth/login.php';
$data = json_encode($testData);

$options = [
    'http' => [
        'header' => "Content-type: application/json\r\n",
        'method' => 'POST',
        'content' => $data
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to connect to login API'
    ]);
} else {
    echo $result;
}
?>
