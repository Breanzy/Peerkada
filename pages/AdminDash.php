<?php session_start();
require_once '../config.php';

if ($_SESSION['role'] != 'admin') {
    // If not set, redirect to login page
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">

    <?php require_once('../components/TopNav.php'); ?>
    <div id="layoutSidenav" class="container mt-3">
        <?php require_once('../components/SideNav.php'); ?>

        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
            <main>
                <?php require_once '../components/Notifications.php'; ?>
                <div class="card mb-3">
                    <div class="card-header mb-1">

                        <h2>Users</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        // Fetch users
                        $query = "SELECT * FROM members_profile WHERE ROLE = 'user'";
                        require_once '../components/TableUsers.php';
                        ?>

                    </div>

                </div>

                <div class="card mb-3">
                    <div class="card-header mb-1">
                        <h2>Attendance Logs (Signed Out)</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        // Fetch attendance logs where TIMEOUT is not null
                        $tableID = 'signedOut';
                        $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NOT NULL ";
                        require '../components/TableAttendance.php';
                        ?>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header mb-1">

                        <h2>Attendance Logs (Missing Sign Out)</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        // Fetch attendance logs where TIMEOUT is null
                        $tableID = 'notSignedOut';
                        $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NULL";
                        require '../components/TableAttendance.php';
                        ?>
                    </div>

                </div>

                <div class="card mb-3">
                    <div class="card-header mb-1">
                        <h2>Unfulfilled Monthly Duties</h2>
                    </div>
                    <div class="p-2">
                        <?php require '../components/TableUnfulfilledDuty.php'; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>