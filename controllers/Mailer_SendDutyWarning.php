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
    $mail->Username   = 'peerkadaIIT@gmail.com';
    $mail->Password   = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    foreach ($unfulfilled as $user) {
        $mail->setFrom('peerkadaIIT@gmail.com', 'Peerkada');
        $mail->addAddress($user['EMAIL_ADD']);
        $mail->addReplyTo('peerkadaIIT@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Peerkada | Insufficient Duty Time Warning: ' . date('F Y', strtotime($currentMonth));
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; line-height: 1.5;'>
            <p style='font-size: 18px; font-weight: bold;'>Dear {$user['NAME']},</p>
            <p style='font-size: 16px;'>We are reaching out to inform you that you currently have insufficient duty time for this month.</p>
            
            <p style='font-size: 16px;'><strong style='font-size: 18px;'>Required Hours:</strong> " . number_format($user['required_hours'], 2) . " hours</p>
            <p style='font-size: 16px;'><strong style='font-size: 18px;'>Total Hours Completed:</strong> " . number_format($user['total_hours'], 2) . " hours</p>
            <p style='font-size: 16px;'><strong style='font-size: 18px;'>Remaining Hours:</strong> " . number_format($user['remaining_hours'], 2) . " hours</p>
            
            <p style='font-size: 16px;'>Please ensure that you complete your remaining hours as soon as possible. Your participation is important for the success of our organization, and we appreciate your efforts.</p>
                        
            <p style='font-size: 16px;'>Thank you.</p>
            <p style='font-size: 12px; color: gray;'>*This is an automated message. Please do not reply.*</p>
        </div>
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
