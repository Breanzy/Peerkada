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
            <?php if (isset($_SESSION['isAdmin'])): ?>
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
                    <?php if (isset($_SESSION['isAdmin'])): ?>
                        <td class='text-center'>
                            <div class="btn-group" role="group">
                                <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1' title="Edit User">Edit</button>
                                <button class='btn btn-danger delete-btn fa-solid fa-trash m-1' title="Delete User">Delete</button>
                                <button class='btn btn-info qr-btn fa-solid fa-qrcode m-1' title="Download QR Code">QR</button>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {

        var table = $('#userTable').DataTable({
            lengthChange: false,
            pageLength: 5,
            responsive: true,
            scrollX: true,
            columnDefs: [{
                className: 'text-center',
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

        // Force column adjustment after a slight delay to ensure DOM is ready
        setTimeout(function() {
            table.columns.adjust().draw();
        }, 100);

        // Ensure column adjustment when tab or panel becomes visible
        $('a[data-bs-toggle="tab"], a[data-bs-toggle="pill"]').on('shown.bs.tab', function() {
            table.columns.adjust().draw();
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
            var name = $(cells[0]).text().trim();
            var idNumber = $(cells[1]).text().trim();
            var title = $(cells[2]).text().trim();
            var college = $(cells[3]).text().trim();
            var schoolYear = $(cells[4]).text().trim();
            var course = $(cells[5]).text().trim();
            var email = $(cells[6]).text().trim();
            var phone = $(cells[7]).text().trim();
            var address = $(cells[8]).text().trim();
            var birthDate = $(cells[9]).text().trim();
            var sex = $(cells[10]).text().trim();

            // Create a modal with a form
            var modalHtml = `
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User: ${name}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editUserForm">
                                <input type="hidden" id="userId" value="${userId}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" value="${name}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="idNumber" class="form-label">ID Number</label>
                                        <input type="number" class="form-control" id="idNumber" value="${idNumber}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="title" class="form-label">Title</label>
                                        <select class="form-control" id="title">
                                            <option value="Assistant" ${title === 'Assistant' ? 'selected' : ''}>Assistant</option>
                                            <option value="Junior" ${title === 'Junior' ? 'selected' : ''}>Junior</option>
                                            <option value="Senior" ${title === 'Senior' ? 'selected' : ''}>Senior</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="college" class="form-label">College</label>
                                        <input type="text" class="form-control" id="college" value="${college}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="schoolYear" class="form-label">School Year</label>
                                        <input type="text" class="form-control" id="schoolYear" value="${schoolYear}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="course" class="form-label">Course</label>
                                        <input type="text" class="form-control" id="course" value="${course}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" value="${email}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="number" class="form-control" id="phone" value="${phone}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sex" class="form-label">Sex</label>
                                        <select class="form-control" id="sex">
                                            <option value="Male" ${sex === 'Male' ? 'selected' : ''}>Male</option>
                                            <option value="Female" ${sex === 'Female' ? 'selected' : ''}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="birthDate" class="form-label">Birth Date</label>
                                        <input type="date" class="form-control" id="birthDate" value="${birthDate}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" value="${address}">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="saveUser">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            `;

            // Remove existing modal if it exists
            $('#editUserModal').remove();

            // Append modal to body
            $('body').append(modalHtml);

            // Initialize and show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();

            // Save button click handler for the modal
            $('#saveUser').off('click').on('click', function() {
                var formData = {
                    userId: $('#userId').val(),
                    name: $('#name').val(),
                    idNumber: $('#idNumber').val(),
                    title: $('#title').val(),
                    college: $('#college').val(),
                    schoolYear: $('#schoolYear').val(),
                    course: $('#course').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                    birthDate: $('#birthDate').val(),
                    sex: $('#sex').val()
                };

                // Validate inputs
                if (!formData.name || !formData.idNumber) {
                    alert('Name and ID Number are required fields');
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: '../controllers/UpdateUsers.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Update the cells in the row
                                $(cells[0]).text(formData.name);
                                $(cells[1]).text(formData.idNumber);
                                $(cells[2]).text(formData.title);
                                $(cells[3]).text(formData.college);
                                $(cells[4]).text(formData.schoolYear);
                                $(cells[5]).text(formData.course);
                                $(cells[6]).text(formData.email);
                                $(cells[7]).text(formData.phone);
                                $(cells[8]).text(formData.address);
                                $(cells[9]).text(formData.birthDate);
                                $(cells[10]).text(formData.sex);

                                // Redraw the table to ensure all DataTables features work correctly
                                table.rows($row).invalidate().draw(false);

                                // Close the modal
                                editModal.hide();

                                // Show success message
                                alert('User information updated successfully!');
                            } else {
                                alert('Error updating user: ' + result.message);
                            }
                        } catch (e) {
                            alert('Error processing server response');
                            console.error('Response:', response);
                            console.error('Error:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating user: ' + error);
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

            // Handle modal close events to ensure clean up
            $('#editUserModal').on('hidden.bs.modal', function() {
                $(this).remove(); // Remove the modal from DOM when closed
            });
        });

    });
</script>