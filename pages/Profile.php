<?php

session_start();
ob_start(); // Start output buffering
require '../config.php';

// Check if the ID is valid
$SchoolID = $_SESSION['name'];

// Fetch profile information
$stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :id");
$stmt->execute(['id' => $SchoolID]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = 'ID Does not exist';
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

// Function to calculate total duty time
function calculateDutyTime($pdo, $SchoolID, $month = null)
{
    $query = "SELECT TIMEIN, TIMEOUT FROM table_attendance WHERE STUDENTID = :id";
    if ($month) {
        $query .= " AND DATE_FORMAT(LOGDATE, '%Y-%m') = :logdate";
    }

    $stmt = $pdo->prepare($query);
    $params = ['id' => $SchoolID];
    if ($month) {
        $params['logdate'] = $month;
    }
    $stmt->execute($params);

    $totalDutyTime = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $signIn = strtotime($row['TIMEIN']);
        $signOut = strtotime($row['TIMEOUT']);

        if ($signIn && $signOut) {
            $totalDutyTime += ($signOut - $signIn);
        }
    }
    return round(($totalDutyTime / 3600), 2); // Convert seconds to hours
}

// Get the current month in 'Y-m' format
$currentMonth = date('Y-m');

// Calculate monthly and total duty time
$MonthlyDutyTime = calculateDutyTime($pdo, $SchoolID, $currentMonth);
$TotalDutyTime = calculateDutyTime($pdo, $SchoolID);
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
    <script src="../js/listhingy.js"></script>z
</head>

<body class="sb-nav-fixed">
    <?php include('../components/TopNav.php'); ?>

    <div id="layoutSidenav">
        <?php include('../components/SideNav.php'); ?>

        <!-- MAIN CONTENT -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-xl-4 p-10 d-flex justify-content-center align-items-center">
                            <div class="" style="height: 250px; width: 250px;">

                                <img src="../assets/backgroundd.jpg" class="h-100 w-100 rounded-circle" style="object-fit: cover;" alt="Image">
                            </div>
                        </div>

                        <div class="col-xl-8 col-md-12 center-align text-lg-start text-center">
                            <h3 class="fw-bold fs-1"><?php echo $Name; ?></h3>
                            <h6 class="theme-color lead"><?php echo $Title; ?></h6>
                            <br>
                            <div class="row about-list">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="media">
                                        <label class="fw-bold">Birthday</label>
                                        <p><?php echo $Birth; ?></p>
                                    </div>
                                    <div class="media">
                                        <label class="fw-bold">Address</label>
                                        <p><?php echo $Address; ?></p>
                                    </div>

                                    <div class="media">
                                        <label class="fw-bold">E-mail</label>
                                        <p><?php echo $Email; ?></p>
                                    </div>
                                    <div class="media">
                                        <label class="fw-bold">Phone</label>
                                        <p><?php echo $Number; ?></p>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12">
                                    <div class="media">
                                        <label class="fw-bold">School ID</label>
                                        <p><?php echo $SchoolID; ?></p>
                                    </div>
                                    <div class="media">
                                        <label class="fw-bold">College</label>
                                        <p><?php echo $College; ?></p>
                                    </div>
                                    <div class="media">
                                        <label class="fw-bold">Course</label>
                                        <p><?php echo $Course; ?></p>
                                    </div>
                                    <div class="media">
                                        <label class="fw-bold">School Year</label>
                                        <p><?php echo $SchoolYr; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Changing card color depending on threshold -->
                    <?php
                    // Constants for percentage thresholds
                    define('LOW_THRESHOLD', 33.33);
                    define('HIGH_THRESHOLD', 66.67);

                    // Calculate required duty hours per week
                    $requiredDutyPerWeek = $DutyHour / 4;

                    // Calculate monthly duty percentage
                    $monthlyPercent = ($DutyHour > 0) ? ($MonthlyDutyTime / $DutyHour) * 100 : 0;

                    // Determine card color based on monthly percentage
                    $cardColor = ($monthlyPercent < LOW_THRESHOLD) ? "danger" : (($monthlyPercent > HIGH_THRESHOLD) ? "success" : "warning");
                    ?>

                    <div class="row justify-content-evenly mt-5">
                        <div class="col-xl-3 col-md-10 shadow rounded-3 p-3 alert d-flex justify-content-center align-items-center">
                            <div class="count-data text-center">
                                <h6 class="fw-bold fs-2"><?php echo htmlspecialchars($requiredDutyPerWeek); ?> Hours</h6>
                                <p class="m-0px font-w-600">Required Duty Per Week</p>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-10 shadow alert alert-<?php echo htmlspecialchars($cardColor); ?> rounded-3 p-3 d-flex justify-content-center align-items-center">
                            <div class="count-data text-center hover-overlay">
                                <h6 class="fw-bold fs-2"><?php echo htmlspecialchars($MonthlyDutyTime); ?> / <?php echo htmlspecialchars($DutyHour); ?></h6>
                                <p class="m-0px font-w-600">Monthly Duty Hours Rendered</p>

                                <div class="progress mb-2">
                                    <div class="progress-bar bg-<?php echo htmlspecialchars($cardColor); ?> progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: <?php echo htmlspecialchars($monthlyPercent); ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-white col-xl-3 col-md-10 shadow rounded-3 p-3 alert bg-dark d-flex justify-content-center align-items-center">
                            <div class="count-data text-center">
                                <h6 class="fw-bold fs-2"><?php echo htmlspecialchars($TotalDutyTime); ?></h6>
                                <p class="m-0px font-w-600">Overall Duty Hours Rendered</p>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-xl">
                            <h2 class="text-center fw-bolder">Duty Logs</h2>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM table_attendance WHERE STUDENTID = $SchoolID AND STATUS = 1 ORDER BY ATTENDANCE_ID DESC");
                            $stmt->execute();

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