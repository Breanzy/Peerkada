<?php
session_start();

// Check if the QR code path is set in the session
if (isset($_SESSION['qr_code_path'])) {
    $filePath = $_SESSION['qr_code_path'];
    $filename = basename($_SESSION['qr_code_name']) . '.png'; // Ensure the filename is safe
    unset($_SESSION['qr_code_path']);
    unset($_SESSION['qr_code_name']);

    // Check if the file exists
    if (file_exists($filePath)) {
        // Clear any output buffer
        if (ob_get_length()) {
            ob_end_clean();
        }
        $_SESSION['success'] = "Successfully registered!.";

        // Set headers to force download
        header("Content-Type: image/png");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . filesize($filePath));
        // Read the file and send it to the output buffer
        readfile($filePath);
        exit(); // Terminate the script after sending the file
    } else {
        // Handle the case where the file does not exist
        $_SESSION['error'] = "File not found.";
        header("Location: ../pages/login.php");
        exit();
    }
} else {
    // Redirect if the session variable is not set
    header("Location: ../pages/login.php");
    exit();
}
