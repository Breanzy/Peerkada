<?php
require_once '../config.php';
session_start();

// Check if user is admin
if (!isset($_SESSION['isAdmin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    // Validate input
    $requiredFields = ['studentId', 'logDate', 'timeIn'];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception("$field is required");
        }
    }

    // Prepare update query
    $query = "UPDATE table_attendance SET 
              LOGDATE = :logDate,
              TIMEIN = :timeIn,
              TIMEOUT = :timeOut
              WHERE STUDENTID = :studentId";

    $stmt = $pdo->prepare($query);

    // Execute update with sanitized data
    $result = $stmt->execute([
        'studentId' => htmlspecialchars($_POST['studentId']),
        'logDate' => htmlspecialchars($_POST['logDate']),
        'timeIn' => htmlspecialchars($_POST['timeIn']),
        'timeOut' => !empty($_POST['timeOut']) ? htmlspecialchars($_POST['timeOut']) : null
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Failed to update attendance record");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
