<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated data from the POST request
    $profileId = $_POST['profileId'];
    $name = $_POST['name'];
    $idNumber = $_POST['idNumber'];
    $title = $_POST['title'];
    $college = $_POST['college'];
    $schoolYear = $_POST['schoolYear'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $birthDate = $_POST['birthDate'];
    $sex = $_POST['sex'];

    // Prepare the SQL update statement
    $query = "UPDATE members_profile SET 
                NAME = :name,
                ID_NUMBER = :idNumber,
                TITLE = :title,
                COLLEGE = :college,
                SHOOL_YR = :schoolYear,
                COURSE = :course,
                EMAIL_ADD = :email,
                PHONE_NUM = :phone,
                ADDRESS = :address,
                BIRTH = :birthDate,
                SEX = :sex
              WHERE PROFILE_ID = :profileId";

    $stmt = $pdo->prepare($query);

    // Bind parameters
    $stmt->bindParam(':profileId', $profileId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':idNumber', $idNumber);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':college', $college);
    $stmt->bindParam(':schoolYear', $schoolYear);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':birthDate', $birthDate);
    $stmt->bindParam(':sex', $sex);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update user.']);
    }
}
?>