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
                            <div class="btn-group" role="group">
                                <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1'>Edit</button>
                                <button class='btn btn-danger delete-btn fa-solid fa-trash m-1'>Delete</button>
                            </div>
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
            var table = $('#<?php echo $tableID; ?>').DataTable();
            var $row = $(this).closest('tr');

            // This gets the correct row data even with pagination, filtering, etc.
            var data = table.row($row).data();

            // If we're in responsive mode, we might need to get the parent row
            if ($row.hasClass('child')) {
                $row = $row.prev();
                data = table.row($row).data();
            }

            // Use data-attendance-id attribute from the actual DOM element
            var attendanceId = $row.data('attendance-id');

            // Get the values from the data array
            var studentId = data[0];
            var logDate = data[1];
            var timeIn = data[2];
            var timeOut = data[3];

            // Convert display time format to HTML time input format (HH:mm)
            function convertToTimeInputFormat(timeStr) {
                if (timeStr === 'N/A' || !timeStr) return '';
                var date = new Date(`2000/01/01 ${timeStr}`);
                return date.getHours().toString().padStart(2, '0') + ':' +
                    date.getMinutes().toString().padStart(2, '0');
            }

            // Create a modal with a form
            var modalHtml = `
            <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance for Student ID: ${studentId}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editAttendanceForm">
                                <input type="hidden" id="attendanceId" value="${attendanceId}">
                                <div class="mb-3">
                                    <label for="logDate" class="form-label">Log Date</label>
                                    <input type="date" class="form-control" id="logDate" value="${logDate}">
                                </div>
                                <div class="mb-3">
                                    <label for="timeIn" class="form-label">Time In</label>
                                    <input type="time" class="form-control" id="timeIn" value="${convertToTimeInputFormat(timeIn)}">
                                </div>
                                <div class="mb-3">
                                    <label for="timeOut" class="form-label">Time Out</label>
                                    <input type="time" class="form-control" id="timeOut" value="${convertToTimeInputFormat(timeOut)}">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cancelAttendance" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveAttendance">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            `;

            // Remove existing modal if it exists
            $('#editAttendanceModal').remove();

            // Append modal to body
            $('body').append(modalHtml);

            // Initialize and show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editAttendanceModal'));
            editModal.show();

            // Save button click handler for the modal
            $('#saveAttendance').off('click').on('click', function() {
                var formData = {
                    attendanceId: $('#attendanceId').val(),
                    logDate: $('#logDate').val(),
                    timeIn: $('#timeIn').val(),
                    timeOut: $('#timeOut').val()
                };

                // Validate inputs
                if (!formData.logDate) {
                    alert('Please enter a log date');
                    return;
                }

                $.ajax({
                    url: '../controllers/UpdateAttendance.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Format times for display
                                const timeInDisplay = formData.timeIn ?
                                    new Date(`2000/01/01 ${formData.timeIn}`).toLocaleTimeString('en-US') : '';
                                const timeOutDisplay = formData.timeOut ?
                                    new Date(`2000/01/01 ${formData.timeOut}`).toLocaleTimeString('en-US') : 'N/A';

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

                                // Create a new array with updated values
                                var newData = [...data]; // Copy the original data array
                                newData[1] = formData.logDate;
                                newData[2] = timeInDisplay;
                                newData[3] = timeOutDisplay;
                                newData[4] = totalTime;

                                // Update the row data and redraw
                                table.row($row).data(newData).draw(false);

                                // Make sure data-attendance-id attribute is preserved
                                $row.attr('data-attendance-id', attendanceId);

                                // Close the modal
                                editModal.hide();

                                // Show success message
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
            });

            // Cancel button handler - just close the modal
            $('#cancelAttendance').off('click').on('click', function() {
                editModal.hide();
            });

            // Handle modal close events to ensure clean up
            $('#editAttendanceModal').on('hidden.bs.modal', function() {
                $(this).remove(); // Remove the modal from DOM when closed
            });
        });
    });
</script>