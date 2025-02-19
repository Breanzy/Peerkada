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
        require_once  '../config.php';
        $attendanceStmt = $pdo->prepare($query);
        $attendanceStmt->execute();
        $logs = $attendanceStmt->fetchAll();
        unset($query);

        if (!empty($logs)) {
            foreach ($logs as $log) { ?>
                <tr>
                    <th scope='row'><?php echo htmlspecialchars($log['STUDENTID']); ?></th>
                    <td><?php echo htmlspecialchars($log['LOGDATE']); ?></td>
                    <td><?php echo htmlspecialchars($log['TIMEIN'] ? date('h:i:s A', strtotime($log['TIMEIN'])) : null); ?></td>
                    <td><?php echo htmlspecialchars($log['TIMEOUT'] ? date('h:i:s A', strtotime($log['TIMEOUT'])) : 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($log['TIMEOUT'] ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", strtotime($log['TIMEOUT']) - strtotime($log['TIMEIN'])) : 'N/A'); ?></td>
                    <?php if (isset($_SESSION['isAdmin'])): ?>
                        <td class='text-center'>
                            <a class='btn btn-warning fa-solid fa-pen-to-square m-1'></a>
                            <a class='btn btn-danger fa-solid fa-trash m-1'></a>
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
    });
</script>

oh lawd the shame