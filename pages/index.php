<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Peerkada | Home</title>

    <!-- para sa mga icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


    <!-- para camera thingy -->
    <script type="text/javascript" src="../js/instascan.min.js"></script>

    <!-- styles  -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/customStyle.css">
    <!-- FOR BUTTON FUNCTIONALITIES -->
    <script src="../js/scripts.js"></script>
    <script src="../js/listhingy.js"></script>

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

                        <div class="col-xl-7 col-lg-6 col-md-10">
                            <h1>Recent Logs</h1>

                            <?php
                            require '../config.php';
                            date_default_timezone_set("Asia/Singapore");
                            $DATE = date('Y-m-d');

                            $stmt = $pdo->prepare("SELECT * FROM table_attendance WHERE LOGDATE = :logdate ORDER BY ATTENDANCE_ID DESC limit 6");
                            $stmt->execute(['logdate' => $DATE]);

                            include '../components/DutyLogTable.php';
                            ?>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>