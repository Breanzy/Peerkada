<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="userTable">
    <thead class="table-dark">
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
                    <?php if (isset($_SESSION['isAdmin'])): ?>
                        <td class='text-center'>
                            <a class='btn btn-warning fa-solid fa-pen-to-square m-1'></a>
                            <a class='btn btn-danger fa-solid fa-trash m-1'></a>
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
    });
</script>