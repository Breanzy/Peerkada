<?php
session_start();
ob_start(); // Start output buffering
require '../config.php';

// Check if Session name is set
if (!isset($_SESSION['name'])) {
    // If not set, redirect to login page
    header('Location: login.php');
    exit();
}

// Check if the ID is valid
$SchoolID = $_SESSION['name'];

// Fetch profile information
$stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :id");
$stmt->execute(['id' => $SchoolID]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = 'ID Does not existtt';
    header("Location: ../pages/login.php");
    exit();
}

if ($row) {
    $Name = $row['NAME'];
    $Title = $row['TITLE'];
    $College = $row['COLLEGE'];
    $SchoolYr = $row['SCHOOL_YR'];
    $Course = $row['COURSE'];
    $Email = $row['EMAIL_ADD'];
    $Number = $row['PHONE_NUM'];
    $Address = $row['ADDRESS'];
    $Birth = $row['BIRTH'];
    $Sex = $row['SEX'];
    //Duty hour requirement per month
    switch ($Title) {
        case 'Assistant':
            $DutyHour = 16;
            break;
        case 'Junior':
            $DutyHour = 12;
            break;
        case 'Senior':
            $DutyHour = 10;
            break;
        case 'LAV':
            $DutyHour = 20;
            break;
        default:
            $DutyHour = 0;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>

    <!-- Icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Styling  -->
    <link rel="stylesheet" href="../css/styles.css">

</head>

<body class="sb-nav-fixed">
    <?php include('../components/TopNav.php'); ?>

    <div id="layoutSidenav">
        <?php include('../components/SideNav.php'); ?>

        <!-- MAIN CONTENT -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-5">

                    <!-- User Details -->
                    <?php include('../components/ProfileDetail.php'); ?>

                    <!-- Duty Hours Rendered -->
                    <?php include('../components/ProfileDutyRendered.php'); ?>

                    <!-- Duty Logs -->
                    <div class="row mt-5">
                        <div class="col-xl">
                            <h2 class="text-center fw-bolder">Duty Logs</h2>
                            <?php

                            $stmt = $pdo->prepare("SELECT * FROM table_attendance WHERE STUDENTID = :studentId AND STATUS = 1 ORDER BY ATTENDANCE_ID DESC");
                            $stmt->execute(['studentId' => $SchoolID]);
                            include '../components/DutyLogTable.php';
                            ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="js/scripts.js"></script>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>