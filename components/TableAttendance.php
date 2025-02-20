<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="<?php echo $tableID; ?>">
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
                <tr data-student-id="<?php echo htmlspecialchars($log['STUDENTID']); ?>">
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
                targets: '_all'
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

        // Edit button click event
        $('#<?php echo $tableID; ?>').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            var studentId = row.data('student-id');
            var logDate = row.find('td:nth-child(2)').text();
            var timeIn = row.find('td:nth-child(3)').text();
            var timeOut = row.find('td:nth-child(4)').text();

            // Replace row content with input fields
            row.html(`
                <th scope='row'>${studentId}</th>
                <td><input type='date' value='${logDate}' class='form-control' name='logDate'></td>
                <td><input type='time' value='${timeIn}' class='form-control' name='timeIn'></td>
                <td><input type='time' value='${timeOut}' class='form-control' name='timeOut'></td>
                <td><span class='total-time'>N/A</span></td>
                <td class='text-center'>
                    <button class='btn btn-success save-btn'>Save</button>
                    <button class='btn btn-secondary cancel-btn'>Cancel</button>
                </td>
            `);

            // Calculate total time on input change
            row.find('input[name="timeIn"], input[name="timeOut"]').on('change', function() {
                var timeInValue = row.find('input[name="timeIn"]').val();
                var timeOutValue = row.find('input[name="timeOut"]').val();
                if (timeInValue && timeOutValue) {
                    var totalTime = (new Date('1970-01-01T' + timeOutValue) - new Date('1970-01-01T' + timeInValue)) / 1000;
                    var hours = Math.floor(totalTime / 3600);
                    var minutes = Math.floor((totalTime % 3600) / 60);
                    var seconds = totalTime % 60;
                    row.find('.total-time').text(`${hours} h ${minutes} m ${seconds} s`);
                }
            });

            // Save button click event
            row.find('.save-btn').on('click', function() {
                var updatedLogDate = row.find('input[name="logDate"]').val();
                var updatedTimeIn = row.find('input[name="timeIn"]').val();
                var updatedTimeOut = row.find('input[name="timeOut"]').val();
                $.ajax({
                    url: 'editusers.php', // Your update script
                    type: 'POST',
                    data: {
                        userId: userId,
                        name: updatedName,
                        title: updatedTitle,
                        college: updatedCollege,
                        schoolYear: updatedSchoolYear,
                        course: updatedCourse,
                        email: updatedEmail,
                        phone: updatedPhone,
                        address: updatedAddress,
                        birthDate: updatedBirthDate,
                        sex: updatedSex
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            alert(result.message);
                            location.reload(); // Reload the page to see changes
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating record: ' + error);
                    }
                });
            });

            // Cancel button click event
            row.find('.cancel-btn').on('click', function() {
                location.reload(); // Reload the page to discard changes
            });
        });
    });
</script>