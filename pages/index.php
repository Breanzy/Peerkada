<?php session_start();
require_once '../config.php';
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
            <?php require_once '../components/Notifications.php'; ?>
            <main>
                <div class="container-fluid p-4">
                    <!-- QR tab -->
                    <div class="d-flex flex-column justify-content-center gap-2">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-camera " aria-hidden="true"></i>
                                QR Scanner
                            </div>
                            <?php require_once '../components/QRCamera.php'; ?>
                        </div>

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