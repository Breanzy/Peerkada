<?php
require_once '../config.php';
session_start();

// Check if user is admin
if (!(isset($_SESSION['isAdmin']) || $_POST['idNumber'] == $_SESSION['ID_Number'])) {
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

    // Check if ID number already exists (excluding the current user)
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM members_profile WHERE ID_NUMBER = :idNumber AND USER_ID != :userId");
    $checkStmt->execute([
        'idNumber' => $_POST['idNumber'],
        'userId' => $_POST['userId']
    ]);

    if ($checkStmt->fetchColumn() > 0) {
        throw new Exception("ID Number already exists");
    }

    // Prepare update query
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

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Failed to update user");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
