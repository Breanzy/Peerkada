<?php
// DeleteUser.php
session_start();

// Check if user is logged in and is an admin
if ($_SESSION['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if user ID was provided
if (!isset($_POST['userId'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
    exit;
}

require_once '../config.php';
require_once 'UserAssetHandler.php';

try {
    // Start transaction
    $pdo->beginTransaction();

    // Get the user ID
    $userId = $_POST['userId'];

    // Initialize the asset handler
    $assetHandler = new UserAssetHandler();

    // Delete associated records first (if any)
    // For example, if you have attendance records linked to this user:
    $stmtAttendance = $pdo->prepare("DELETE FROM table_attendance WHERE STUDENTID = ?");
    $stmtAttendance->execute([$userId]);

    // Delete the user profile
    $stmtUser = $pdo->prepare("DELETE FROM members_profile WHERE ID_NUMBER = ?");
    $result = $stmtUser->execute([$userId]);

    if ($result) {
        // Delete user's assets (profile picture and QR code)
        $assetResult = $assetHandler->deleteUserAssets($userId);

        $pdo->commit();
        echo json_encode([
            'success' => true,
            'message' => 'User deleted successfully',
            'assetResults' => $assetResult
        ]);
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
