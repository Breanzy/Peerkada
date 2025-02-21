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
    $requiredFields = ['attendanceId', 'logDate', 'timeIn'];

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
              WHERE ATTENDANCE_ID = :attendanceId";

    $stmt = $pdo->prepare($query);

    // Execute update with sanitized data
    $result = $stmt->execute([
        'logDate' => htmlspecialchars($_POST['logDate']),
        'timeIn' => htmlspecialchars($_POST['timeIn']),
        'timeOut' => !empty($_POST['timeOut']) ? htmlspecialchars($_POST['timeOut']) : null,
        'attendanceId' => htmlspecialchars($_POST['attendanceId']),
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Failed to update attendance record");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
