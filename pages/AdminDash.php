
try {
    // Fetch users
    $userQuery = "SELECT * FROM members_profile";
    $userStmt = $pdo->prepare($userQuery);
    $userStmt->execute();
    $users = $userStmt->fetchAll();

    // Fetch attendance logs where TIMEOUT is not null
    $attendanceQuery = "SELECT * FROM table_attendance WHERE TIMEOUT IS NOT NULL";
    $attendanceStmt = $pdo->prepare($attendanceQuery);
    $attendanceStmt->execute();
    $attendanceLogs = $attendanceStmt->fetchAll();

    // Fetch attendance logs where TIMEOUT is null
    $missingSignOutQuery = "SELECT * FROM table_attendance WHERE TIMEOUT IS NULL";
    $missingSignOutStmt = $pdo->prepare($missingSignOutQuery);
    $missingSignOutStmt->execute();
    $missingSignOutLogs = $missingSignOutStmt->fetchAll();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Admin Dashboard</title>
</head>

<body class="sb-nav-fixed">

    <div id="layoutSidenav" class="container mt-3">

        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
            <main>

                <h1>Admin Dashboard</h1>

                <form action="">
                    <h2>Users</h2>
                    <table id="usersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>College</th>
                                <th>School Year</th>
                                <th>Course</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Birth Date</th>
                                <th>Sex</th>
                                <th>Actions</th> <!-- New column for actions -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)) {
                                foreach ($users as $user) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['NAME']); ?></td>
                                        <td><?php echo htmlspecialchars($user['TITLE']); ?></td>
                                        <td><?php echo htmlspecialchars($user['COLLEGE']); ?></td>
                                        <td><?php echo htmlspecialchars($user['SCHOOL_YR']); ?></td>
                                        <td><?php echo htmlspecialchars($user['COURSE']); ?></td>
                                        <td><?php echo htmlspecialchars($user['EMAIL_ADD']); ?></td>
                                        <td><?php echo htmlspecialchars($user['PHONE_NUM']); ?></td>
                                        <td><?php echo htmlspecialchars($user['ADDRESS']); ?></td>
                                        <td><?php echo htmlspecialchars($user['BIRTH']); ?></td>
                                        <td><?php echo htmlspecialchars($user['SEX']); ?></td>
                                        <td>
                                            <button type="button" onclick="editRow(this)">Edit</button>
                                            <button type="button" onclick="deleteRow(this)">Delete</button>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="11">No users found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

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