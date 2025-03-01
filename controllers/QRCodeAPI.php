<?php
session_start();
require_once '../config.php';
require_once 'QrCodeController.php';

$qrController = new QrCodeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = $_POST['userId'] ?? '';
    $name = $_POST['name'] ?? '';

    switch ($action) {
        case 'generate':
            // Generate QR code during registration
            $result = $qrController->generateQrCode($userId, $name);
            echo json_encode($result);
            break;

        case 'download':
            // Check if QR code exists first
            $filename = $qrController->sanitizeFilename($userId) . '.png';
            $filePath = $qrController->getBaseDir() . $filename;

            // If QR code doesn't exist, create one
            if (!file_exists($filePath)) {
                // Get user name from database
                $stmt = $pdo->prepare("SELECT NAME FROM members_profile WHERE ID_NUMBER = :id");
                $stmt->execute(['id' => $userId]);
                $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($userRow) {
                    // Generate the QR code with the user's name
                    $qrController->generateQrCode($userId, $userRow['NAME']);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'error' => 'User not found']);
                    exit();
                }
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
