<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../auth/auth_helper.php';
require_once 'InspectionManager.php';

// Start session
session_start();

// Check if user is logged in
requireLogin();

// Get current user
$user = getCurrentUser();
if (!$user) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    // Validate required fields
    $requiredFields = ['owner', 'location', 'businessName', 'applicationType', 'lcNumber', 'mbNumber'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Field '{$field}' is required");
        }
    }
    
    // Prepare form data
    $formData = [
        'owner' => $input['owner'],
        'location' => $input['location'],
        'businessName' => $input['businessName'],
        'applicationType' => $input['applicationType'],
        'lcNumber' => $input['lcNumber'],
        'mbNumber' => $input['mbNumber'],
        'applicationDate' => $input['applicationDate'] ?? '',
        'returnDate' => $input['returnDate'] ?? '',
        'timeIn' => $input['timeIn'] ?? '',
        'timeOut' => $input['timeOut'] ?? '',
        'inspectionDate' => $input['inspectionDate'] ?? '',
        'assessment' => $input['assessment'] ?? '',
        'remarks' => $input['remarks'] ?? '',
        'notes' => $input['notes'] ?? '',
        'calculatedFee' => $input['calculatedFee'] ?? '0.00'
    ];
    
    // Prepare fee data if provided
    $feeData = [];
    if (isset($input['refrigeration'])) {
        $feeData['refrigeration'] = $input['refrigeration'];
    }
    if (isset($input['airConditioning'])) {
        $feeData['air_conditioning'] = $input['airConditioning'];
    }
    if (isset($input['ventilation'])) {
        $feeData['ventilation'] = $input['ventilation'];
    }
    if (isset($input['escalators'])) {
        $feeData['escalators'] = $input['escalators'];
    }
    if (isset($input['elevators'])) {
        $feeData['elevators'] = $input['elevators'];
    }
    
    // Add electrical/electronics specific fees
    if (isset($input['connectedLoadKva'])) {
        $feeData['electrical_load'] = [
            'kva' => $input['connectedLoadKva'],
            'category' => $input['connectedLoadCategory'] ?? ''
        ];
    }
    if (isset($input['transformerKva'])) {
        $feeData['transformer'] = [
            'kva' => $input['transformerKva'],
            'category' => $input['transformerCategory'] ?? ''
        ];
    }
    if (isset($input['switchingPorts'])) {
        $feeData['switching'] = [
            'ports' => $input['switchingPorts']
        ];
    }
    if (isset($input['broadcastLocations'])) {
        $feeData['broadcast'] = [
            'locations' => $input['broadcastLocations']
        ];
    }
    
    // Create inspection
    $inspectionManager = new InspectionManager();
    $result = $inspectionManager->createInspection(
        $user['id'],
        $user['role'],
        $formData,
        $feeData
    );
    
    echo json_encode([
        'success' => true,
        'message' => 'Inspection created successfully',
        'data' => $result
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
