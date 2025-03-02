<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden w-100" id="<?php echo $tableID; ?>">
    <thead class="table-dark">
        <tr>
            <th scope="col">Student ID</th>
            <th scope="col">Log Date</th>
            <th scope="col">Time In</th>
            <th scope="col">Time Out</th>
            <th scope="col">Total Time</th>
            <?php if (isset($_SESSION['isAdmin'])): ?>
                <th scope="col">Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../config.php';
        $attendanceStmt = $pdo->prepare($query);
        $attendanceStmt->execute();
        $logs = $attendanceStmt->fetchAll();
        unset($query);

        if (!empty($logs)) {
            foreach ($logs as $log) { ?>
                <tr data-attendance-id="<?php echo htmlspecialchars($log['ATTENDANCE_ID']); ?>">
                    <th scope='row'><?php echo htmlspecialchars($log['STUDENTID']); ?></th>
                    <td><?php echo htmlspecialchars($log['LOGDATE']); ?></td>
                    <td><?php echo htmlspecialchars($log['TIMEIN'] ? date('h:i:s A', strtotime($log['TIMEIN'])) : null); ?></td>
                    <td><?php echo htmlspecialchars($log['TIMEOUT'] ? date('h:i:s A', strtotime($log['TIMEOUT'])) : 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($log['TIMEOUT'] ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", strtotime($log['TIMEOUT']) - strtotime($log['TIMEIN'])) : 'N/A'); ?></td>
                    <?php if (isset($_SESSION['isAdmin'])): ?>
                        <td class='text-center'>
                            <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1'>Edit</button>
                            <button class='btn btn-danger delete-btn fa-solid fa-trash m-1'>Delete</button>
                        </td>
                    <?php endif; ?>
                </tr>
        <?php };
        } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var table = $('#<?php echo $tableID; ?>').DataTable({
            lengthChange: false,
            pageLength: 5,
            autoWidth: true,
            responsive: true,
            scrollX: true,
            columnDefs: [{
                className: 'text-center',
                targets: '_all',
                width: '1%',
            }],
            buttons: [{
                    text: "View ",
                    className: 'btn btn-dark',
                    extend: 'colvis'
                },
                {
                    text: 'Excel <i class="fas fa-file-excel"></i>',
                    className: 'btn btn-outline-success btn-light',
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });

        table.buttons().container().appendTo('#<?php echo $tableID; ?>_wrapper .col-md-6:eq(0)');

        // Add this to your existing $(document).ready function
        $('#<?php echo $tableID; ?>').on('click', '.delete-btn', function() {
            var row = $(this).closest('tr');
            var attendanceId = row.data('attendance-id');
            var studentId = row.find('th:first').text();

            // Show confirmation dialog
            if (confirm(`Are you sure you want to delete the attendance record for Student ID: ${studentId}?`)) {
                $.ajax({
                    url: '../controllers/DeleteAttendance.php',
                    method: 'POST',
                    data: {
                        attendanceId: attendanceId
                    },
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Remove the row from the table
                                row.fadeOut(400, function() {
                                    // Get the DataTable instance
                                    var table = $('#<?php echo $tableID; ?>').DataTable();
                                    // Remove the row from DataTable
                                    table.row(row).remove().draw();
                                });
                                alert('Attendance record deleted successfully!');
                            } else {
                                alert('Error deleting attendance: ' + result.message);
                            }
                        } catch (e) {
                            alert('Error processing server response');
                            console.error('Response:', response);
                            console.error('Error:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting attendance: ' + error);
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
        });

        // Edit button click handler
        $('#<?php echo $tableID; ?>').on('click', '.edit-btn', function() {
            // Remove any existing event handlers
            $('#<?php echo $tableID; ?>').off('click', '.save-btn');
            $('#<?php echo $tableID; ?>').off('click', '.cancel-btn');

            var row = $(this).closest('tr');
            var attendanceId = row.data('attendance-id');
            var studentId = row.find('th:nth-child(1)').text();
            var logDate = row.find('td:nth-child(2)').text();
            var timeIn = row.find('td:nth-child(3)').text();
            var timeOut = row.find('td:nth-child(4)').text();

            // Convert display time format to HTML time input format (HH:mm)
            function convertToTimeInputFormat(timeStr) {
                if (timeStr === 'N/A' || !timeStr) return '';
                var date = new Date(`2000/01/01 ${timeStr}`);
                return date.getHours().toString().padStart(2, '0') + ':' +
                    date.getMinutes().toString().padStart(2, '0');
            }

            // Replace row content with input fields
            row.html(`
            <th scope='row'>${studentId}</th>
            <td><input type='date' value='${logDate}' class='form-control' name='logDate'></td>
            <td><input type='time' value='${convertToTimeInputFormat(timeIn)}' class='form-control' name='timeIn'></td>
            <td><input type='time' value='${convertToTimeInputFormat(timeOut)}' class='form-control' name='timeOut'></td>
            <td>Calculated on save</td>
            <td class='text-center'>
                <div class="btn-group" role="group">
                    <button class='btn btn-success save-btn m-1 fa-check fa-solid'>Save</button>
                    <button class='btn btn-secondary cancel-btn m-1 fa-times fa-solid'>Cancel</button>
                </div>
            </td>
        `);

            // Save button click handler
            $('#<?php echo $tableID; ?>').on('click', '.save-btn', function() {
                var saveRow = $(this).closest('tr');
                var formData = {
                    attendanceId: attendanceId,
                    logDate: saveRow.find('input[name="logDate"]').val(),
                    timeIn: saveRow.find('input[name="timeIn"]').val(),
                    timeOut: saveRow.find('input[name="timeOut"]').val()
                };

                $.ajax({
                    url: '../controllers/UpdateAttendance.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Format times for display
                                const timeInDisplay = formData.timeIn ? new Date(`2000/01/01 ${formData.timeIn}`).toLocaleTimeString('en-US') : '';
                                const timeOutDisplay = formData.timeOut ? new Date(`2000/01/01 ${formData.timeOut}`).toLocaleTimeString('en-US') : 'N/A';

                                // Calculate total time
                                let totalTime = 'N/A';
                                if (formData.timeIn && formData.timeOut) {
                                    const timeInMs = new Date(`2000/01/01 ${formData.timeIn}`).getTime();
                                    const timeOutMs = new Date(`2000/01/01 ${formData.timeOut}`).getTime();
                                    const diff = Math.floor((timeOutMs - timeInMs) / 1000); // difference in seconds

                                    const hours = Math.floor(diff / 3600);
                                    const minutes = Math.floor((diff % 3600) / 60);
                                    const seconds = diff % 60;
                                    totalTime = `${hours} hrs, ${minutes} mins, ${seconds} secs`;
                                }

                                // Update the row with new values
                                saveRow.html(`
                                <th scope='row'>${studentId}</th>
                                <td>${formData.logDate}</td>
                                <td>${timeInDisplay}</td>
                                <td>${timeOutDisplay}</td>
                                <td>${totalTime}</td>
                                <td class='text-center'>
                                    <div class="btn-group" role="group">
                                        <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1'>Edit</button>
                                        <button class='btn btn-danger delete-btn fa-solid fa-trash m-1'>Delete</button>
                                    </div>
                                </td>
                            `);

                                alert('Attendance record updated successfully!');
                            } else {
                                alert('Error updating attendance: ' + result.message);
                            }
                        } catch (e) {
                            alert('Error processing server response');
                            console.error('Response:', response);
                            console.error('Error:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating attendance: ' + error);
                        console.error('AJAX Error:', status, error);
                    }
                });

                // Clean up event handlers
                $('#<?php echo $tableID; ?>').off('click', '.save-btn');
                $('#<?php echo $tableID; ?>').off('click', '.cancel-btn');
            });

            // Cancel button click handler
            $('#<?php echo $tableID; ?>').on('click', '.cancel-btn', function() {
                var cancelRow = $(this).closest('tr');
                // Revert back to original row data
                cancelRow.html(`
                <th scope='row'>${studentId}</th>
                <td>${logDate}</td>
                <td>${timeIn}</td>
                <td>${timeOut}</td>
                <td>${row.find('td:nth-child(5)').text()}</td>
                <td class='text-center'>
                    <div class="btn-group" role="group">
                        <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1'>Edit</button>
                        <button class='btn btn-danger delete-btn fa-solid fa-trash m-1'>Delete</button>
                    </div>
                </td>
            `);

                // Clean up event handlers
                $('#<?php echo $tableID; ?>').off('click', '.save-btn');
                $('#<?php echo $tableID; ?>').off('click', '.cancel-btn');
            });
        });
    });
</script>