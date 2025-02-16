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

                <h1>Admin Dashboard</h1>
                <?php require_once '../components/Notifications.php'; ?>

                <form action="">
                    <h2>Users</h2>

                    <?php
                    // Fetch users
                    $query = "SELECT * FROM members_profile";
                    require_once '../components/TableUsers.php';
                    ?>

                    <h2>Attendance Logs (Signed Out)</h2>
                    <?php
                    // Fetch attendance logs where TIMEOUT is not null
                    $tableID = 'signedOut';
                    $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NOT NULL";
                    require '../components/TableAttendance.php';
                    ?>

                    <h2>Attendance Logs (Missing Sign Out)</h2>
                    <?php
                    // Fetch attendance logs where TIMEOUT is null
                    $tableID = 'notSignedOut';
                    $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NULL";
                    require '../components/TableAttendance.php';

                    ?>

                </form>
            </main>
        </div>
    </div>
</body>

</html>