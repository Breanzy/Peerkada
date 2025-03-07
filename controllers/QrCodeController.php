<?php
require_once '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class QrCodeController
{
    private $baseDir;

    public function __construct()
    {
        $this->baseDir = __DIR__ . '/../assets/QrCodes/';
        if (!file_exists($this->baseDir)) {
            mkdir($this->baseDir, 0755, true);
        }
    }

    public function generateQrCode($userId)
    {
        try {
            $writer = new PngWriter();
            $qrCode = new QrCode(
                data: $userId,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High
            );

            $filename = $this->sanitizeFilename($userId) . '.png';
            $filePath = $this->baseDir . $filename;

            $result = $writer->write($qrCode);
            $result->saveToFile($filePath);

            return [
                'success' => true,
                'filename' => $filename,
                'filepath' => $filePath
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function downloadQrCode($userId)
    {
        $filename = $this->sanitizeFilename($userId) . '.png';
        $filePath = $this->baseDir . $filename;

        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'error' => 'QR Code not found'
            ];
        }

        return [
            'success' => true,
            'filepath' => $filePath,
            'filename' => $filename
        ];
    }

    public function sanitizeFilename($filename)
    {
        return preg_replace('/[^a-zA-Z0-9-_]/', '', $filename);
    }

    // New method to expose the base directory
    public function getBaseDir()
    {
        return $this->baseDir;
    }
}
