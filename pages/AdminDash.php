<?php
session_start();
// Include the PDO configuration
require '../config.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peerkada | Admin Dashboard</title>
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

    <script>
        function editRow(button) {
            var row = button.parentNode.parentNode; // Get the row of the button
            var cells = row.getElementsByTagName("td");

            // Loop through each cell and replace the text with input fields
            for (var i = 0; i < cells.length - 1; i++) { // Exclude the last cell (Actions)
                var cellValue = cells[i].innerHTML;

                // Determine the type of input based on the column index
                switch (i) {
                    case 1: // Title column
                        cells[i].innerHTML = `
                    <select>
                        <option value="junior" ${cellValue === 'junior' ? 'selected' : ''}>junior</option>
                        <option value="senior" ${cellValue === 'senior' ? 'selected' : ''}>senior</option>
                        <option value="advocate" ${cellValue === 'advocate' ? 'selected' : ''}>advocate</option>
                    </select>`;
                        break;
                    case 5: // Email column
                        cells[i].innerHTML = `<input type="email" value="${cellValue}" />`;
                        break;
                    case 6: // Phone Number column
                        cells[i].innerHTML = `<input type="number" value="${cellValue}" />`;
                        break;
                    case 8: // Birth Date column
                        cells[i].innerHTML = `<input type="date" value="${cellValue}" />`;
                        break;
                    default:
                        cells[i].innerHTML = `<input type="text" value="${cellValue}" />`;
                        break;
                }
            }

            // Change the button to confirm
            button.innerHTML = "Confirm";
            button.setAttribute("onclick", "confirmEdit(this)");
        }

        function confirmEdit(button) {
            var row = button.parentNode.parentNode; // Get the row of the button
            var cells = row.getElementsByTagName("td");
            var updatedData = [];

            // Collect updated values from input fields
            for (var i = 0; i < cells.length - 1; i++) {
                if (cells[i].getElementsByTagName("select").length > 0) {
                    // If it's a dropdown, get the selected value
                    updatedData.push(cells[i].getElementsByTagName("select")[0].value);
                } else {
                    updatedData.push(cells[i].getElementsByTagName("input")[0].value);
                }
            }

            // Send updated data to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle response if needed
                    console.log(xhr.responseText);
                    // Optionally refresh the page or update the row with new data
                }
            };
            xhr.send("data=" + JSON.stringify(updatedData)); // Send data as JSON
        }
    </script>
</head>

<body class="sb-nav-fixed">

    <?php include('../components/TopNav.php'); ?>
    <div id="layoutSidenav" class="container mt-3">
        <?php include('../components/SideNav.php'); ?>

        <div id="layoutSidenav_content" class="d-flex flex-column justify-content-start">
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

        </div>
    </div>
</body>

</html>