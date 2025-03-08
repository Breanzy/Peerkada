<?php
require_once '../config.php';
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get the user ID to reset password for
if (!isset($_POST['userId']) || empty($_POST['userId'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
    exit;
}

$userId = $_POST['userId'];
$id_number = isset($_SESSION['ID_NUMBER']) ? $_SESSION['ID_NUMBER'] : null;

// Check authorization: Either the user is resetting their own password or they're an admin
if ($userId != $id_number && $_SESSION['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if new password was provided
if (!isset($_POST['newPassword']) || empty($_POST['newPassword'])) {
    echo json_encode(['success' => false, 'message' => 'New password is required']);
    exit;
}

$newPassword = $_POST['newPassword'];

try {
    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the password in the database
    $stmt = $pdo->prepare("UPDATE members_profile SET PASSWORD = :password WHERE ID_NUMBER = :userId");
    $result = $stmt->execute([
        'password' => $hashedPassword,
        'userId' => $userId
    ]);

    if ($result && $stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Password reset successfully'
        ]);
    } else {
        throw new Exception("User not found or password reset failed");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
