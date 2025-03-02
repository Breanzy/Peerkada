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
            <th>Actions</th>
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

        table.buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');

        // Add QR code download handler
        $('#userTable').on('click', '.qr-btn', function() {
            var table = $('#userTable').DataTable();
            var rowData = table.row($(this).closest('tr')).data();

            // If rowData is undefined (common in rendered HTML tables), get data from cells
            if (!rowData) {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                // Using cell().data() to get values
                var userId = table.cell(row.index(), 1).data(); // ID_NUMBER column (index 1)
                var userName = table.cell(row.index(), 0).data(); // NAME column (index 0)
            } else {
                var userId = rowData[1]; // Access via array index
                var userName = rowData[0];
            }

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
            var row = $(this).closest('tr');
            var userId = row.data('user-id');
            var userName = row.find('td:first').text();

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
                                // Remove the row from the table with animation
                                row.fadeOut(400, function() {
                                    // Get the DataTable instance
                                    var table = $('#userTable').DataTable();
                                    // Remove the row from DataTable
                                    table.row(row).remove().draw();
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

        // Use one global event handler for the edit button
        $('#userTable').on('click', '.edit-btn', function() {
            // Remove any existing event handlers for save and cancel
            $('#userTable').off('click', '.save-btn');
            $('#userTable').off('click', '.cancel-btn');

            var row = $(this).closest('tr');
            var userId = row.data('user-id');
            var name = row.find('td:nth-child(1)').text();
            var idNumber = row.find('td:nth-child(2)').text();
            var title = row.find('td:nth-child(3)').text();
            var college = row.find('td:nth-child(4)').text();
            var schoolYear = row.find('td:nth-child(5)').text();
            var course = row.find('td:nth-child(6)').text();
            var email = row.find('td:nth-child(7)').text();
            var phone = row.find('td:nth-child(8)').text();
            var address = row.find('td:nth-child(9)').text();
            var birthDate = row.find('td:nth-child(10)').text();
            var sex = row.find('td:nth-child(11)').text();

            // Replace row content with input fields
            row.html(`
            <td><input type='text' value='${name}' class='form-control' name='name'></td>
            <td><input type='number' value='${idNumber}' class='form-control' name='idNumber'></td>
            <td>
                <select class='form-control' name='title'>
                    <option value='Assistant' ${title === 'Assistant' ? 'selected' : ''}>Assistant</option>
                    <option value='Junior' ${title === 'Junior' ? 'selected' : ''}>Junior</option>
                    <option value='Senior' ${title === 'Senior' ? 'selected' : ''}>Senior</option>
                </select>
            </td>
            <td><input type='text' value='${college}' class='form-control' name='college'></td>
            <td><input type='text' value='${schoolYear}' class='form-control' name='schoolYear'></td>
            <td><input type='text' value='${course}' class='form-control' name='course'></td>
            <td><input type='email' value='${email}' class='form-control' name='email'></td>
            <td><input type='number' value='${phone}' class='form-control' name='phone'></td>
            <td><input type='text' value='${address}' class='form-control' name='address'></td>
            <td><input type='date' value='${birthDate}' class='form-control' name='birthDate'></td>
            <td>
                <select class='form-control' name='sex'>
                    <option value='Male' ${sex === 'Male' ? 'selected' : ''}>Male</option>
                    <option value='Female' ${sex === 'Female' ? 'selected' : ''}>Female</option>
                </select>
            </td>
            <td class='text-center'>
                <div class="btn-group" role="group">
                    <button class='btn btn-success save-btn m-1 fa-check fa-solid'>Save</button>
                    <button class='btn btn-secondary cancel-btn m-1 fa-times fa-solid'>Cancel</button>
                </div>
            </td>
        `);

            // Add new save button handler
            $('#userTable').on('click', '.save-btn', function() {
                var saveRow = $(this).closest('tr');
                var formData = {
                    userId: userId,
                    name: saveRow.find('input[name="name"]').val(),
                    idNumber: saveRow.find('input[name="idNumber"]').val(),
                    title: saveRow.find('select[name="title"]').val(),
                    college: saveRow.find('input[name="college"]').val(),
                    schoolYear: saveRow.find('input[name="schoolYear"]').val(),
                    course: saveRow.find('input[name="course"]').val(),
                    email: saveRow.find('input[name="email"]').val(),
                    phone: saveRow.find('input[name="phone"]').val(),
                    address: saveRow.find('input[name="address"]').val(),
                    birthDate: saveRow.find('input[name="birthDate"]').val(),
                    sex: saveRow.find('select[name="sex"]').val()
                };

                // Send AJAX request
                $.ajax({
                    url: '../controllers/UpdateUsers.php', // Create this PHP file to handle the update
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.success) {
                                // Update the row with new values
                                saveRow.html(`
                                <td>${formData.name}</td>
                                <td>${formData.idNumber}</td>
                                <td>${formData.title}</td>
                                <td>${formData.college}</td>
                                <td>${formData.schoolYear}</td>
                                <td>${formData.course}</td>
                                <td>${formData.email}</td>
                                <td>${formData.phone}</td>
                                <td>${formData.address}</td>
                                <td>${formData.birthDate}</td>
                                <td>${formData.sex}</td>
                            <td class='text-center'>
                                <div class="btn-group" role="group">
                                    <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1' title="Edit User">Edit</button>
                                    <button class='btn btn-danger delete-btn fa-solid fa-trash m-1' title="Delete User">Delete</button>
                                    <button class='btn btn-info qr-btn fa-solid fa-qrcode m-1' title="Download QR Code">QR</button>
                                </div>
                            </td>
                            `);

                                // Show success message
                                alert('User information updated successfully!');

                                // Clean up event handlers
                                $('#userTable').off('click', '.save-btn');
                                $('#userTable').off('click', '.cancel-btn');
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



            // Add new cancel button handler
            $('#userTable').on('click', '.cancel-btn', function() {
                var cancelRow = $(this).closest('tr');
                // Revert back to original row data
                cancelRow.html(`
                <td>${name}</td>
                <td>${idNumber}</td>
                <td>${title}</td>
                <td>${college}</td>
                <td>${schoolYear}</td>
                <td>${course}</td>
                <td>${email}</td>
                <td>${phone}</td>
                <td>${address}</td>
                <td>${birthDate}</td>
                <td>${sex}</td>
                <td class='text-center'>
                    <div class="btn-group" role="group">
                        <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1' title="Edit User">Edit</button>
                        <button class='btn btn-danger delete-btn fa-solid fa-trash m-1' title="Delete User">Delete</button>
                        <button class='btn btn-info qr-btn fa-solid fa-qrcode m-1' title="Download QR Code">QR</button>
                    </div>
                </td>
            `);

                // Clean up event handlers
                $('#userTable').off('click', '.save-btn');
                $('#userTable').off('click', '.cancel-btn');
            });
        });
    });
</script>