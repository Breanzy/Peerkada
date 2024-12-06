<?php session_start();

//For QR Code Generation
require '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\ErrorCorrectionLevel;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Form Contents
    $Name = $_POST['Name'];
    $SchoolID = $_POST['SchoolID'];
    $Title = $_POST['Title'];
    $College = $_POST['College'];
    $SchoolYr = $_POST['SchoolYr'];
    $Course = $_POST['Course'];
    $Email = $_POST['Email'];
    $Number = $_POST['Number'];
    $Address = $_POST['Address'];
    $Birth = $_POST['Birth'];
    $Sex = $_POST['Sex'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT);

    // Check if ID Number already exists in the database
    require '../config.php';
    $stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :SchoolID");
    $stmt->execute(['SchoolID' => $SchoolID]);

    if ($stmt->rowCount() > 0) {
        // Registered Profile already exists
        $_SESSION['error'] = "ID Number Already Exist in the Database!";
        header("location: ../pages/login.php");
        exit();
    } else {
        // Proceed with function
        $stmt = $pdo->prepare(
            "INSERT INTO members_profile 
        (NAME, ID_NUMBER, TITLE, COLLEGE, SCHOOL_YR, COURSE, EMAIL_ADD, PHONE_NUM, ADDRESS, BIRTH, SEX, PASSWORD) 
        VALUES (:Name, :SchoolID, :Title, :College, :SchoolYr, :Course, :Email, :Number, :Address, :Birth, :Sex, :Password)"
        );

        if ($stmt->execute([
            ':Name' => $Name,
            ':SchoolID' => $SchoolID,
            ':Title' => $Title,
            ':College' => $College,
            ':SchoolYr' => $SchoolYr,
            ':Course' => $Course,
            ':Email' => $Email,
            ':Number' => $Number,
            ':Address' => $Address,
            ':Birth' => $Birth,
            ':Sex' => $Sex,
            ':Password' => $Password,
        ])) {

            // Create QR code
            $writer = new PngWriter();
            $qrCode = new QrCode(
                data: $SchoolID,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High
            );

            $logo = new Logo(
                path: __DIR__ . '/../assets/LogoRed.png',
                resizeToWidth: 125,
                punchoutBackground: false
            );

            $label = new Label(text: $Name);
            $result = $writer->write($qrCode, $logo, $label);
            $result->saveToFile(__DIR__ . '/../assets/QrCodes/' . $Name . '.png');

            $_SESSION['success'] = "Successfully Registered New Profile!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->errorInfo()[2];
        }
        header("location: ../pages/login.php");
        exit();
    }
} else {
    header("location:../pages/login.php");
    exit();
}
