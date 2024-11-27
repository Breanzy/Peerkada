<?php
require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;

$writer = new PngWriter();

// Create QR code
$qrCode = new QrCode(data: 'Life is too short to be generating QR codes', encoding: new Encoding('UTF-8'));

$logo = new Logo(
    path: __DIR__ . '/assets/LogoRed.png',
    resizeToWidth: 50,
    punchoutBackground: false
);

// Create generic label
$label = new Label(
    text: 'Breanzy Boi',
);

$result = $writer->write($qrCode, $logo, $label);

header('Content-Type: ' . $result->getMimeType());
echo $result->getString();

$result->saveToFile(__DIR__ . '/qrcode.png');
