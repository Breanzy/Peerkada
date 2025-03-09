<?php
require_once '../config.php';
require_once 'UserAssetHandler.php';
session_start();

// Check if user is admin
if ($_SESSION['role'] != 'admin' && $_POST['idNumber'] != $_SESSION['ID_Number']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    // Validate input
    $requiredFields = [
        'userId',
        'name',
        'idNumber',
        'title',
        'college',
        'schoolYear',
        'course',
        'email',
        'phone',
        'address',
        'birthDate',
        'sex'
    ];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception("$field is required");
        }
    }

    // Validate email format
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format");
    }

    // Fetch the current ID number to check if it's being changed
    $currentIdStmt = $pdo->prepare("SELECT ID_NUMBER FROM members_profile WHERE USER_ID = :userId");
    $currentIdStmt->execute(['userId' => $_POST['userId']]);
    $currentIdNumber = $currentIdStmt->fetchColumn();
    $idNumberChanged = ($currentIdNumber !== $_POST['idNumber']);

    // Check if ID number already exists (excluding the current user)
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM members_profile WHERE ID_NUMBER = :idNumber AND USER_ID != :userId");
    $checkStmt->execute([
        'idNumber' => $_POST['idNumber'],
        'userId' => $_POST['userId']
    ]);

    if ($checkStmt->fetchColumn() > 0) {
        throw new Exception("ID Number already exists");
    }

    // Start transaction to ensure both updates succeed or fail together
    $pdo->beginTransaction();

    // Prepare update query for user profile
    $query = "UPDATE members_profile SET
        NAME = :name,
        ID_NUMBER = :idNumber,
        TITLE = :title,
        COLLEGE = :college,
        SCHOOL_YR = :schoolYear,
        COURSE = :course,
        EMAIL_ADD = :email,
        PHONE_NUM = :phone,
        ADDRESS = :address,
        BIRTH = :birthDate,
        SEX = :sex
        WHERE USER_ID = :userId";

    $stmt = $pdo->prepare($query);

    // Execute update with sanitized data
    $result = $stmt->execute([
        'name' => htmlspecialchars($_POST['name']),
        'idNumber' => htmlspecialchars($_POST['idNumber']),
        'title' => htmlspecialchars($_POST['title']),
        'college' => htmlspecialchars($_POST['college']),
        'schoolYear' => htmlspecialchars($_POST['schoolYear']),
        'course' => htmlspecialchars($_POST['course']),
        'email' => htmlspecialchars($_POST['email']),
        'phone' => htmlspecialchars($_POST['phone']),
        'address' => htmlspecialchars($_POST['address']),
        'birthDate' => htmlspecialchars($_POST['birthDate']),
        'sex' => htmlspecialchars($_POST['sex']),
        'userId' => htmlspecialchars($_POST['userId'])
    ]);

    // Initialize the asset handler
    $assetHandler = new UserAssetHandler();
    $assetResults = ['updated' => false];

    // If ID number was changed, update assets and attendance records
    if ($idNumberChanged && $result) {
        // Update the attendance records with the new ID number
        $attendanceQuery = "UPDATE table_attendance SET 
                            STUDENTID = :newIdNumber 
                            WHERE STUDENTID = :oldIdNumber";

        $attendanceStmt = $pdo->prepare($attendanceQuery);
        $attendanceResult = $attendanceStmt->execute([
            'newIdNumber' => htmlspecialchars($_POST['idNumber']),
            'oldIdNumber' => $currentIdNumber
        ]);

        if (!$attendanceResult) {
            // If attendance update fails, roll back the transaction
            $pdo->rollBack();
            throw new Exception("Failed to update attendance records");
        }

        // Update user's assets (profile picture and QR code)
        $assetResults = $assetHandler->updateUserAssets(
            $currentIdNumber,
            htmlspecialchars($_POST['idNumber'])
        );
    }

    // Commit the transaction if everything succeeded
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'assetResults' => $assetResults
    ]);
} catch (Exception $e) {
    // Roll back transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
