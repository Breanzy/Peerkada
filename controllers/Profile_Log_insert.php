<?php session_start();


//For QR Code Generation
require "vendor/autoload.php";


use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


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
$Password = $_POST['Password'];

// Calculates total duty time per month according to title. I think this function could be optimized.
if ($Title == 'Assistant') {
    $DutyHour = 16;
} else if ($Title == 'Junior') {
    $DutyHour = 12;
} else if ($Title == 'Senior') {
    $DutyHour = 10;
} else if ($Title == 'LAV') {
    $DutyHour = 20;
} else {
    $DutyHour = 0;
}

$sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$SchoolID'";
if ($conn->query($sql)->num_rows > 0) {
    // Registered Profile already exists
    $_SESSION['error'] = "ID Number Already Exist in the Database!";

    header("location: register.php");
    $conn->close();
} else {
    // Proceed with function
    $sql = "INSERT INTO members_profile(NAME, ID_NUMBER, TITLE, COLLEGE, SCHOOL_YR, COURSE, EMAIL_ADD, PHONE_NUM, ADDRESS, BIRTH, SEX, PASSWORD, DUTYHOUR) 
        VALUES('$Name', '$SchoolID', '$Title', '$College', '$SchoolYr', '$Course', '$Email', '$Number', '$Address', '$Birth', '$Sex', '$Password', '$DutyHour')";

    if ($conn->query($sql) === TRUE) {

        $qr_code = QrCode::create($SchoolID);
        $writer = new PngWriter();
        $result = $writer->write($qr_code);

        $result->saveToFile(__DIR__ . '/QrCodes/' . $Name . '.png');

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $result->getMimeType());
        header('Content-Disposition: /image');

        $_SESSION['success'] = "Successfully Registered New Profile!";
    } else {
        $_SESSION['error'] = $conn->error;
    }

    header("location: index.php");
    $conn->close();
}
