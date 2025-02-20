<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="userTable">
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
                <tr data-user-id="<?php echo htmlspecialchars($user['PROFILE_ID']); ?>">
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
                                <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1'>Edit</button>
                                <button class='btn btn-danger delete-btn fa-solid fa-trash m-1'>Delete</button>
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

        table.buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');

        // Edit button click event
        $('#userTable').on('click', '.edit-btn', function() {
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
                <td><input type='text' value='${idNumber}' class='form-control' name='idNumber'></td>
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
                <td><input type='text' value='${phone}' class='form-control' name='phone'></td>
                <td><input type='text' value='${address}' class='form-control' name='address'></td>
                <td><input type='date' value='${birthDate}' class='form-control' name='birthDate'></td>
                <td>
                    <select class='form-control' name='sex'>
                        <option value='Male' ${sex === 'Male' ? 'selected' : ''}>Male</option>
                        <option value='Female' ${sex === 'Female' ? 'selected' : ''}>Female</option>
                    </select>
                </td>
                <td class='text-center'>
                    <button class='btn btn-success save-btn m-1'>Save</button>
                    <button class='btn btn-secondary cancel-btn m-1'>Cancel</button>
                </td>
            `);

            // Save button click event
            row.find('.save-btn').on('click', function() {
                // Collect updated data and send to server for saving
                var updatedData = {
                    profileId: userId, // Use profile Id as the unique identifier
                    name: row.find('input[name="name"]').val(),
                    idNumber: row.find('input[name="idNumber"]').val(),
                    title: row.find('select[name="title"]').val(),
                    college: row.find('input[name="college"]').val(),
                    schoolYear: row.find('input[name="schoolYear"]').val(),
                    course: row.find('input[name="course"]').val(),
                    email: row.find('input[name="email"]').val(),
                    phone: row.find('input[name="phone"]').val(),
                    address: row.find('input[name="address"]').val(),
                    birthDate: row.find('input[name="birthDate"]').val(),
                    sex: row.find('select[name="sex"]').val()
                };

                console.log(updatedData); // Log the data being sent


            });

            // Cancel button click event
            row.find('.cancel-btn').on('click', function() {
                // Revert back to original row data
                row.html(`
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
                            <button class='btn btn-warning edit-btn fa-solid fa-pen-to-square m-1'>Edit</button>
                            <button class='btn btn-danger delete-btn fa-solid fa-trash m-1'>Delete</button>
                        </div>
                    </td>
                `);
            });
        });
    });
</script>