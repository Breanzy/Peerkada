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
                    <table id="attendanceTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Logdate</th>
                                <th>Status</th>
                                <th>Actions</th> <!-- New column for actions -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($attendanceLogs)) {
                                foreach ($attendanceLogs as $log) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($log['STUDENTID']); ?></td>
                                        <td><?php echo date('h:i:s A', (strtotime($log['TIMEIN']))); ?></td>
                                        <td><?php echo date('h:i:s A', (strtotime($log['TIMEOUT']))) ?></td>
                                        <td><?php echo htmlspecialchars($log['LOGDATE']); ?></td>
                                        <td><?php echo htmlspecialchars($log['STATUS']); ?></td>
                                        <td>
                                            <button type="button" onclick="editRow(this)">Edit</button>
                                            <button type="button" onclick="deleteRow(this)">Delete</button>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6">No attendance logs found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <h2>Attendance Logs (Missing Sign Out)</h2>
                    <table id="missingSignOutTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Logdate</th>
                                <th>Status</th>
                                <th>Actions</th> <!-- New column for actions -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($missingSignOutLogs)) {
                                foreach ($missingSignOutLogs as $log) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($log['STUDENTID']); ?></td>
                                        <td><?php echo htmlspecialchars($log['TIMEIN']); ?></td>
                                        <td><?php echo htmlspecialchars("Missing"); ?></td>
                                        <td><?php echo htmlspecialchars($log['LOGDATE']); ?></td>
                                        <td><?php echo htmlspecialchars($log['STATUS']); ?></td>
                                        <td>
                                            <button type="button" onclick="editRow(this)">Edit</button>
                                            <button type="button" onclick="deleteRow(this)">Delete</button>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5">No missing sign out logs found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </main>
        </div>
    </div>
</body>

</html>