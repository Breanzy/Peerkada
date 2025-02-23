<?php
// DeleteUser.php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['isAdmin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if user ID was provided
if (!isset($_POST['userId'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
    exit;
}

require_once '../config.php';

try {
    // Start transaction
    $pdo->beginTransaction();

    // Get the user ID
    $userId = $_POST['userId'];

    // Delete associated records first (if any)
    // For example, if you have attendance records linked to this user:
    $stmtAttendance = $pdo->prepare("DELETE FROM table_attendance WHERE STUDENTID = (SELECT ID_NUMBER FROM members_profile WHERE USER_ID = ?)");
    $stmtAttendance->execute([$userId]);

    // Delete the user profile
    $stmtUser = $pdo->prepare("DELETE FROM members_profile WHERE USER_ID = ?");
    $result = $stmtUser->execute([$userId]);

    if ($result) {
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
    } else {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
    }
} catch (PDOException $e) {
    // Roll back the transaction if something failed
    $pdo->rollBack();
    error_log('Delete User Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
}
