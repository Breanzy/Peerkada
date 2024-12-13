<?php
// Include the PDO configuration
require '../config.php';

try {
    // Fetch users
    $userQuery = "SELECT * FROM members_profile";
    $userStmt = $pdo->prepare($userQuery);
    $userStmt->execute();
    $users = $userStmt->fetchAll();

    // Fetch attendance logs
    $attendanceQuery = "SELECT * FROM table_attendance";
    $attendanceStmt = $pdo->prepare($attendanceQuery);
    $attendanceStmt->execute();
    $attendanceLogs = $attendanceStmt->fetchAll();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>

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
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Attendance Logs</h2>
        <table id="attendanceTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Logdate</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendanceLogs)) {
                    foreach ($attendanceLogs as $log) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['STUDENTID']); ?></td>
                            <td><?php echo htmlspecialchars($log['TIMEIN']); ?></td>
                            <td><?php echo htmlspecialchars($log['TIMEOUT']); ?></td>
                            <td><?php echo htmlspecialchars($log['LOGDATE']); ?></td>
                            <td><?php echo htmlspecialchars($log['STATUS']); ?></td>
                        </tr> <?php }
                        } else { ?>
                    <tr>
                        <td colspan="4">No attendance logs found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#attendanceTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>