<?php session_start();
require_once '../config.php';

if (!isset($_SESSION['isAdmin'])) {
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
</head>

<body class="sb-nav-fixed">

    <?php require_once('../components/TopNav.php'); ?>
    <div id="layoutSidenav" class="container mt-3">
        <?php require_once('../components/SideNav.php'); ?>

        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
            <main>
                <?php require_once '../components/Notifications.php'; ?>
                <h1>Admin Dashboard</h1>

                <div class="card mb-3">
                    <div class="card-header mb-1">

                        <h2>Users</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        // Fetch users
                        $query = "SELECT * FROM members_profile";
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
                        $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NOT NULL";
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
            </main>
        </div>
    </div>
</body>

</html>