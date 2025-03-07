<?php
session_start();
require_once '../config.php';
require_once 'QrCodeController.php';

$qrController = new QrCodeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = $_POST['userId'] ?? '';

    switch ($action) {
        case 'generate':
            // Generate QR code during registration
            $result = $qrController->generateQrCode($userId);
            echo json_encode($result);
            break;

        case 'download':
            // Check if QR code exists first
            $filename = $qrController->sanitizeFilename($userId) . '.png';
            $filePath = $qrController->getBaseDir() . $filename;

            // If QR code doesn't exist, create one
            if (!file_exists($filePath)) {
                $qrController->generateQrCode($userId);
            }

            // Now download the QR code (either existing or newly created)
            $result = $qrController->downloadQrCode($userId);

            if ($result['success']) {
                header('Content-Type: image/png');
                header('Content-Disposition: attachment; filename="' . $result['filename'] . '"');
                header('Content-Length: ' . filesize($result['filepath']));
                readfile($result['filepath']);
                exit();
            } else {
                http_response_code(404);
                echo json_encode($result);
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
}
