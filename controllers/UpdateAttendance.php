<?php
require_once '../config.php';
session_start();

// Check if user is admin
if ($_SESSION['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    // Validate input
    $requiredFields = ['attendanceId', 'logDate', 'timeIn', 'timeOut'];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception("$field is required");
        }
    }

    // Format times for database storage (HH:MM:SS format)
    $timeIn = $_POST['timeIn'] . ':00'; // Add seconds to the time
    $timeOut = $_POST['timeOut'] . ':00';

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
        'timeIn' => $timeIn,
        'timeOut' => $timeOut,
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
