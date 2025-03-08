<?php
session_start();
require_once '../config.php';

// Retrieve the input ID number from POST data
$text = $_POST['text'];

// Prepare the SQL statement to check if the ID number exists in the profile DB
$stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :id_number");
$stmt->execute(['id_number' => $text]);

//IF TRUE, UPDATE NEW TIME OUT LOG AND ADD TOTAL TIME TO TOTAL TIME DB
if ($stmt->rowCount() > 0) {
    // SET TIMEZONE TO ASIA FOR SYNCHRONIZED TIME RECORDING
    date_default_timezone_set("Asia/Singapore");
    $date = date('Y-m-d');
    $time = date('His');

    // Prepare the SQL statement to check for unclosed time-in logs
    $attendanceStmt = $pdo->prepare("SELECT * FROM table_attendance WHERE STUDENTID = :student_id AND LOGDATE = :log_date AND TIMEOUT IS NULL");
    $attendanceStmt->execute(['student_id' => $text, 'log_date' => $date]);

    // IF TRUE, UPDATE NEW TIME OUT LOG
    if ($attendanceStmt->rowCount() > 0) {
        // Prepare the update statement
        $updateStmt = $pdo->prepare("UPDATE table_attendance SET TIMEOUT = :timeout WHERE STUDENTID = :student_id AND LOGDATE = :log_date AND TIMEOUT IS NULL");
        $updateStmt->execute([
            'timeout' => $time,
            'student_id' => $text,
            'log_date' => $date
        ]);
        $successMessage = urlencode("Successfully Signed Out!");
        header("location: ../pages/index.php?success=" . $successMessage);
    } else {
        // IF FALSE, CREATE A NEW UNCLOSED TIME-IN LOG
        $insertStmt = $pdo->prepare("INSERT INTO table_attendance (STUDENTID, TIMEIN, LOGDATE) VALUES (:student_id, :timein, :log_date)");
        $insertStmt->execute([
            'student_id' => $text,
            'timein' => $time,
            'log_date' => $date,
        ]);
        $successMessage = urlencode("Successfully Signed In!");
        header("location: ../pages/index.php?success=" . $successMessage);
    }
} else {
    $errorMessage = urlencode('No Such Member ID exist!');
    header("location: ../pages/index.php?error=" . $errorMessage);
}

exit();
