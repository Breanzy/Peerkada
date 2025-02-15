<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Home</title>
</head>

<body class="sb-nav-fixed">

    <?php require('../components/TopNav.php'); ?>
    <div id="layoutSidenav" class="container mt-3">
        <?php require('../components/SideNav.php'); ?>

        <!-- THE WHOLE CONTENT -->
        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
            <!-- Notifications -->
            <?php require '../components/Notifications.php'; ?>
            <main>
                <div class="container-fluid p-4">
                    <!-- QR tab -->
                    <div class="d-flex flex-column justify-content-center gap-2">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-camera " aria-hidden="true"></i>
                                QR Scanner
                            </div>
                            <?php include '../components/QRCamera.php'; ?>
                        </div>

                        <div class="card">
                            <div class="card-header mb-2">
                                <i class="fa-solid fa-arrows-rotate " aria-hidden="true"></i>
                                Recent Logs
                            </div>

                            <div class="p-2">
                                <?php
                                require '../config.php';
                                date_default_timezone_set("Asia/Singapore");
                                $DATE = date('Y-m-d');
                                $stmt = $pdo->prepare("SELECT * FROM table_attendance WHERE LOGDATE = :logdate ORDER BY ATTENDANCE_ID DESC limit 6");
                                $stmt->execute(['logdate' => $DATE]);
                                include '../components/TableAttendance.php';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>