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

    <!-- para chada na table. Jesus It's a lot -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

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

    <?php include('../components/TopNav.php'); ?>
    <div id="layoutSidenav" class="container mt-3">
        <?php include('../components/SideNav.php'); ?>

        <!-- THE WHOLE CONTENT -->
        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
            <!-- Notifications -->
            <?php require '../components/Notifications.php'; ?>
            <main>
                <div class="container-fluid p-4">
                    <!-- QR tab -->
                    <div class="row d-flex justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-10">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fa fa-camera " aria-hidden="true"></i>
                                    QR Scanner
                                </div>

                                <div class="card-body" style="position: relative;">
                                    <div id="timer-container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); aspect-ratio: 1;">
                                        <svg width="100%" height="100%" viewBox="0 0 200 200">
                                            <circle cx="100" cy="100" r="90" stroke="#007bff" stroke-width="10" fill="none" stroke-dasharray="565" stroke-dashoffset="565" transform="rotate(-90 100 100)">
                                                <animate attributeName="stroke-dashoffset" from="565" to="0" dur="2s" fill="freeze" />
                                            </circle>
                                        </svg>
                                    </div>
                                    <video id="preview" class="rounded-3" width="100%"></video>
                                </div>
                            </div>
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

    <div id="form-container">
        <form action="../controllers/QR_Log_insert.php" method="post" class="form-horizontal" name="text">
            <input type="hidden" name="text" id="text" readonny="" placeholder="scan qrcode" class="form-control">
        </form>
    </div>


    <!-- FOR CAMERA -->
    <script>
        setTimeout(function() {
            document.getElementById('timer-container').style.display = 'none';
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview')
            });
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert('No cameras found');
                }
            }).catch(function(e) {
                console.error(e);
            });

            // Enable the form elements after 3 seconds
            scanner.addListener('scan', function(c) {
                document.getElementById('text').value = c;
                document.forms['text'].submit();
            });
        }, 2000);
    </script>