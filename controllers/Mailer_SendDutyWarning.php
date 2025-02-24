<?php
// File: ../controllers/Mailer_SendDutyWarning.php

// Include database connection
require_once '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Fetch unfulfilled users
$currentMonth = date('Y-m');
$monthStart = $currentMonth . '-01';
$monthEnd = date('Y-m-t');

$query = "
SELECT 
    mp.NAME,
    mp.ID_NUMBER,
    mp.TITLE,
    mp.EMAIL_ADD,
    COALESCE(SUM(TIMESTAMPDIFF(MINUTE, ta.TIMEIN, ta.TIMEOUT)) / 60, 0) as total_hours,
    CASE 
        WHEN mp.TITLE = 'Senior' THEN 10
        WHEN mp.TITLE = 'Junior' THEN 12
        ELSE 16 
    END as required_hours,
    CASE 
        WHEN mp.TITLE = 'Senior' THEN 10
        WHEN mp.TITLE = 'Junior' THEN 12
        ELSE 16 
    END - COALESCE(SUM(TIMESTAMPDIFF(MINUTE, ta.TIMEIN, ta.TIMEOUT)) / 60, 0) as remaining_hours
FROM 
    members_profile mp
LEFT JOIN 
    table_attendance ta ON mp.ID_NUMBER = ta.STUDENTID 
    AND ta.LOGDATE >= ? 
    AND ta.LOGDATE <= ?
    AND ta.TIMEOUT IS NOT NULL
GROUP BY 
    mp.USER_ID, mp.NAME, mp.ID_NUMBER, mp.TITLE, mp.EMAIL_ADD
HAVING 
    remaining_hours > 0
ORDER BY 
    remaining_hours DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$monthStart, $monthEnd]);
$unfulfilled = $stmt->fetchAll();

// Proceed only if there are users
if (empty($unfulfilled)) {
    echo json_encode(['success' => false, 'message' => 'No users with unfulfilled duties.']);
    exit;
}

$mail = new PHPMailer(true);
$results = [];

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'julius.carbonilla@gmail.com';
    $mail->Password   = 'ymag uqbe ctkt iwhq';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    foreach ($unfulfilled as $user) {
        $mail->setFrom('julius.carbonilla@gmail.com', 'Breanzyy');
        $mail->addAddress($user['EMAIL_ADD']);
        $mail->addReplyTo('julius.carbonilla@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'OSPF | Insufficient Duty Time Warning - Id Number: ' . $user['NAME'];
        $mail->Body = "
            <p>Dear {$user['NAME']},</p>
            <p>This is a reminder that you have insufficient duty time for the current month.</p>
            <p><strong>Total Hours Completed:</strong> {$user['total_hours']} hours</p>
            <p><strong>Required Hours:</strong> {$user['required_hours']} hours</p>
            <p>Please make sure to fulfill your duty requirements as soon as possible.</p>
            <p>Thank you!</p>
        ";

        if ($mail->send()) {
            $results[] = ['email' => $user['EMAIL_ADD'], 'status' => 'success'];
        } else {
            $results[] = ['email' => $user['EMAIL_ADD'], 'status' => 'error', 'message' => $mail->ErrorInfo];
        }
        $mail->clearAddresses();
    }

    // Check if all emails were sent successfully
    $errors = array_filter($results, function ($result) {
        return $result['status'] === 'error';
    });

    if (empty($errors)) {
        echo json_encode(['success' => true, 'message' => 'All warning emails sent successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Some emails could not be sent.', 'errors' => $errors]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $e->getMessage()]);
}
