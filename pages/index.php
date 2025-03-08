<?php session_start();
require_once '../config.php';
if (!isset($_SESSION['role'])) {
    // If not set, redirect to login page
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Home</title>
</head>

<body class="sb-nav-fixed">

    <?php require_once('../components/TopNav.php'); ?>
    <div id="layoutSidenav" class="container mt-3">
        <?php require_once('../components/SideNav.php'); ?>

        <!-- THE WHOLE CONTENT -->
        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
            <!-- Notifications -->
            <main>
                <div class="container-fluid d-flex flex-column justify-content-start gap-2">

                    <?php
                    if ($_SESSION['role'] == 'scanner') {
                        //Only show when role is scanner
                        require_once '../components/QRCamera.php';
                    } ?>

                    <div class="d-flex flex-column justify-content-center gap-2">
                        <div class="card">
                            <div class="card-header mb-2">
                                <i class="fa-solid fa-arrows-rotate " aria-hidden="true"></i>
                                Recent Logs
                            </div>

                            <div class="p-2">
                                <?php
                                date_default_timezone_set("Asia/Singapore");
                                $DATE = date('Y-m-d');
                                $tableID = 'recentID';
                                $query = "SELECT * FROM table_attendance WHERE LOGDATE = '$DATE' ORDER BY ATTENDANCE_ID DESC limit 6";
                                require_once '../components/TableAttendance.php';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>