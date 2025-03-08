<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden w-100" id="userTable">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>ID Number</th>
            <th>Title</th>
            <th>College</th>
            <th>School Year</th>
            <th>Course</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Birth Date</th>
            <th>Sex</th>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../config.php';
        $userStmt = $pdo->prepare($query);
        $userStmt->execute();
        $users = $userStmt->fetchAll();
        unset($query);

        if (!empty($users)) {
            foreach ($users as $user) { ?>
                <tr data-user-id="<?php echo htmlspecialchars($user['USER_ID']); ?>">
                    <td><?php echo htmlspecialchars($user['NAME']); ?></td>
                    <td><?php echo htmlspecialchars($user['ID_NUMBER']); ?></td>
                    <td><?php echo htmlspecialchars($user['TITLE']); ?></td>
                    <td><?php echo htmlspecialchars($user['COLLEGE']); ?></td>
                    <td><?php echo htmlspecialchars($user['SCHOOL_YR']); ?></td>
                    <td><?php echo htmlspecialchars($user['COURSE']); ?></td>
                    <td><?php echo htmlspecialchars($user['EMAIL_ADD']); ?></td>
                    <td><?php echo htmlspecialchars($user['PHONE_NUM']); ?></td>
                    <td><?php echo htmlspecialchars($user['ADDRESS']); ?></td>
                    <td><?php echo htmlspecialchars(trim($user['BIRTH'])); ?></td>
                    <td><?php echo htmlspecialchars($user['SEX']); ?></td>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <td class='text-center'>
                            <div class="btn-group" role="group">
                                <button class="btn btn-warning edit-btn m-1" title="Edit User">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit User
                                </button>
                                <button class="btn btn-danger delete-btn m-1" title="Delete User">
                                    <i class="fa-solid fa-trash"></i> Delete User
                                </button>
                                <button class="btn btn-info qr-btn m-1" title="Download QR Code">
                                    <i class="fa-solid fa-qrcode"></i> Download QR Code
                                </button>
                                <button class="btn btn-primary reset-pwd-btn m-1" title="Reset Password">
                                    <i class="fa-solid fa-key"></i> Reset Password
                                </button>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>

<?php include('../components/EditUserModal.php'); ?>
<script src="../js/EditUserScript.js"></script>
<?php include('../components/ResetPasswordModal.php'); ?>
<script src="../js/ResetPasswordScript.js"></script>

<script>
    $(document).ready(function() {

        var table = $('#userTable').DataTable({
            lengthChange: false,
            pageLength: 5,
            responsive: true,
            scrollX: true,
            columnDefs: [{
                className: 'text-center align-middle',
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
            ],
            // Add initialization complete callback
            initComplete: function() {
                // Adjust columns when window is resized
                $(window).resize(function() {
                    table.columns.adjust().draw();
                });

                // Initial adjustment of columns
                this.api().columns.adjust().draw();
            }
        });

        table.buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');

        // Add QR code download handler
        $('#userTable').on('click', '.qr-btn', function() {
            var table = $('#userTable').DataTable();
            var $row = $(this).closest('tr');

            // This handles responsive mode and child rows
            if ($row.hasClass('child')) {
                $row = $row.prev();
            }

            var tableRow = table.row($row);

            // Get data from the specific row
            var cells = tableRow.nodes().to$().find('td');

            var userName = $(cells[0]).text().trim();
            var userId = $(cells[1]).text().trim();

            // First generate/ensure QR code exists
            $.ajax({
                url: '../controllers/QRCodeAPI.php',
                method: 'POST',
                data: {
                    action: 'generate',
                    userId: userId,
                    name: userName
                },
                success: function(response) {
                    try {
                        const result = JSON.parse(response);
                        if (result.success) {
                            // Create form for download
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '../controllers/QRCodeAPI.php';

                            const actionInput = document.createElement('input');
                            actionInput.type = 'hidden';
                            actionInput.name = 'action';
                            actionInput.value = 'download';

                            const userIdInput = document.createElement('input');
                            userIdInput.type = 'hidden';
                            userIdInput.name = 'userId';
                            userIdInput.value = userId;

                            form.appendChild(actionInput);
                            form.appendChild(userIdInput);
                            document.body.appendChild(form);
                            form.submit();
                            document.body.removeChild(form);
                        } else {
                            alert('Error generating QR code: ' + result.error);
                        }
                    } catch (e) {
                        alert('Error processing server response');
                        console.error('Response:', response);
                        console.error('Error:', e);
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Error generating QR code';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.error || errorMessage;
                    } catch (e) {
                        console.error('Raw server error:', xhr.responseText);
                    }
                    alert(errorMessage);
                }
            });
        });

        // Delete function
        $('#userTable').on('click', '.delete-btn', function() {
            var table = $('#userTable').DataTable();
            var $row = $(this).closest('tr'); // This is jQuery object

            // This handles responsive mode and child rows
            if ($row.hasClass('child')) {
                $row = $row.prev();
            }

            var tableRow = table.row($row);

            // Get data from the specific row
            var cells = tableRow.nodes().to$().find('td');
            var userName = $(cells[0]).text().trim();
            var userId = $(cells[1]).text().trim();

            // Show confirmation dialog with user name
            if (confirm(`Are you sure you want to delete the user "${userName}"? This action cannot be undone.`)) {
                $.ajax({
                    url: '../controllers/DeleteUser.php',
                    method: 'POST',
                    data: {
                        userId: userId
                    },

                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Use $row instead of row here
                                $row.fadeOut(400, function() {
                                    // Get the DataTable instance
                                    table.row($row).remove().draw();
                                });
                                alert('User deleted successfully!');
                            } else {
                                alert('Error deleting user: ' + result.message);
                            }
                        } catch (e) {
                            alert('Error processing server response');
                            console.error('Response:', response);
                            console.error('Error:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting user: ' + error);
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
        });

        // Edit user function
        $('#userTable').on('click', '.edit-btn', function() {
            var table = $('#userTable').DataTable();
            var $row = $(this).closest('tr');

            // This handles responsive mode and child rows
            if ($row.hasClass('child')) {
                $row = $row.prev();
            }

            var tableRow = table.row($row);
            var userId = $row.data('user-id');

            // Get data from the specific row
            var cells = tableRow.nodes().to$().find('td');

            // Extract data directly from the table cells
            var userData = {
                userId: userId,
                name: $(cells[0]).text().trim(),
                idNumber: $(cells[1]).text().trim(),
                title: $(cells[2]).text().trim(),
                college: $(cells[3]).text().trim(),
                schoolYear: $(cells[4]).text().trim(),
                course: $(cells[5]).text().trim(),
                email: $(cells[6]).text().trim(),
                phone: $(cells[7]).text().trim(),
                address: $(cells[8]).text().trim(),
                birthDate: $(cells[9]).text().trim(),
                sex: $(cells[10]).text().trim()
            };

            // Load and show modal
            userEditModal.loadUserData(userData);
            userEditModal.showModal();

            // Handle callback for when data is updated
            $(document).on('user-data-updated', function(e, updatedData) {
                // Update the cells in the row
                $(cells[0]).text(updatedData.name);
                $(cells[1]).text(updatedData.idNumber);
                $(cells[2]).text(updatedData.title);
                $(cells[3]).text(updatedData.college);
                $(cells[4]).text(updatedData.schoolYear);
                $(cells[5]).text(updatedData.course);
                $(cells[6]).text(updatedData.email);
                $(cells[7]).text(updatedData.phone);
                $(cells[8]).text(updatedData.address);
                $(cells[9]).text(updatedData.birthDate);
                $(cells[10]).text(updatedData.sex);

                // Redraw the table to ensure all DataTables features work correctly
                table.rows($row).invalidate().draw(false);
            });
        });

        // Reset Password button handler
        $('#userTable').on('click', '.reset-pwd-btn', function() {
            var table = $('#userTable').DataTable();
            var $row = $(this).closest('tr');

            // This handles responsive mode and child rows
            if ($row.hasClass('child')) {
                $row = $row.prev();
            }

            var tableRow = table.row($row);

            // Get data from the specific row
            var cells = tableRow.nodes().to$().find('td');
            var userName = $(cells[0]).text().trim();
            var userId = $(cells[1]).text().trim();

            // Show reset password modal
            resetPasswordModal.showModal(userId, userName);
        });

    });
</script>