<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard - SB Admin</title>

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

    <div id="layoutSidenav">
        <?php include('../components/SideNav.php'); ?>


        <!-- THE WHOLE CONTENT -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-4">

                    <!-- QR tab -->
                    <div class="row">

                        <div class="col-xl-5 col-lg-6 col-md-10">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fa fa-camera " aria-hidden="true"></i>
                                    QR Scanner
                                </div>

                                <div class="card-body">
                                    <video id="preview" class="rounded-3" width="100%"></video>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-6 col-md-10">
                            <h1>Recent Logs</h1>

                            <table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="example">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Log Date</th>
                                        <th scope="col">Time In</th>
                                        <th scope="col">Time Out</th>
                                        <th scope="col">Total Time</th>
                                        <th scope="col">Actions</td>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    require '../config.php';
                                    date_default_timezone_set("Asia/Singapore");
                                    $DATE = date('Y-m-d');

                                    $stmt = $pdo->prepare("SELECT * FROM table_attendance WHERE LOGDATE = :logdate ORDER BY ATTENDANCE_ID DESC limit 6");
                                    $stmt->execute(['logdate' => $DATE]);

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $studentId = htmlspecialchars($row['STUDENTID']);
                                        $logDate = htmlspecialchars($row['LOGDATE']);
                                        $timeInTimestamp = strtotime($row['TIMEIN']);
                                        $timeOutTimestamp = strtotime($row['TIMEOUT']);
                                        $timeIn = $row['TIMEIN'] ? date('h:i:s A', $timeInTimestamp) : null;
                                        $timeOut = $row['TIMEOUT'] ? date('h:i:s A', $timeOutTimestamp) : null;
                                        $totalTime = $row['TIMEOUT'] ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", $timeOutTimestamp - $timeInTimestamp) : null;

                                        echo "
                                        <tr>
                                            <th scope='row'>{$studentId}</th>
                                            <td>{$logDate}</td>
                                            <td>{$timeIn}</td>
                                            <td>{$timeOut}</td>
                                            <td>{$totalTime}</td>
                                            <td class='text-center'>
                                                <a class='btn btn-warning fa-solid fa-pen-to-square m-1'></a>
                                                <a class='btn btn-danger fa-solid fa-trash m-1'></a>
                                            </td>
                                        </tr>";
                                    }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="container-fluid p-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Area Chart Example
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Bar Chart Example
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                </div>


            </main>
        </div>
    </div>

    <!-- Notifications -->
    <?php
    if (isset($_SESSION['error'])) {
        echo "
            <div class='position-absolute top-0 end-0 alert alert-danger alert-dismissible fadee' style='background:red;color:#fff'>
                <h4><i class='icon fa fa-warning fadee'></i> Error!</h4>
                " . $_SESSION['error'] . "
            </div>
            ";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "
            <div class='position-absolute top-0 end-0 alert alert-success alert-dismissible fadee' style='background:green;color:#fff'>
                <h4><i class='icon fa fa-check'></i> Success!</h4>
                " . $_SESSION['success'] . "
            </div>
            ";
        unset($_SESSION['success']);
    } ?>


    <!-- Hidden text input for passing qr code -->
    <div class="col-md-4">
        <form action="../controllers/QR_Log_insert.php" method="post" class="form-horizontal" name="text">
            <input type="hidden" name="text" id="text" readonny="" placeholder="scan qrcode" class="form-control">
        </form>
    </div>


    <!-- FOR CAMERA -->
    <script>
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

        scanner.addListener('scan', function(c) {
            document.getElementById('text').value = c;
            document.forms['text'].submit();
        });
    </script>

</body>

</html>