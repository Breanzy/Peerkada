<?php
// DeleteAttendance.php
session_start();

// Check if user is logged in and is an admin
if ($_SESSION['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if attendance ID was provided
if (!isset($_POST['attendanceId'])) {
    echo json_encode(['success' => false, 'message' => 'Attendance ID is required']);
    exit;
}

require_once '../config.php';

try {
    // Prepare and execute the delete statement
    $stmt = $pdo->prepare("DELETE FROM table_attendance WHERE ATTENDANCE_ID = ?");
    $result = $stmt->execute([$_POST['attendanceId']]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Attendance record deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete attendance record']);
    }
} catch (PDOException $e) {
    error_log('Delete Attendance Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
}
