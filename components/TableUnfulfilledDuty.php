<?php
// File: components/TableUnfulfilledDuty.php

// Get the current month's start and end dates
$currentMonth = date('Y-m');
$monthStart = $currentMonth . '-01';
$monthEnd = date('Y-m-t');

// Modified query to work with TIME columns
$query = "
SELECT 
    mp.NAME,
    mp.ID_NUMBER,
    mp.TITLE,
    mp.EMAIL_ADD,
    COALESCE(
        SUM(
            TIMESTAMPDIFF(
                MINUTE,
                ta.TIMEIN,
                ta.TIMEOUT
            )
        ) / 60,
        0
    ) as total_hours,
    CASE 
        WHEN mp.TITLE = 'Senior' THEN 10
        WHEN mp.TITLE = 'Junior' THEN 12
        ELSE 16 
    END as required_hours,
    CASE 
        WHEN mp.TITLE = 'Senior' THEN 10
        WHEN mp.TITLE = 'Junior' THEN 12
        ELSE 16 
    END - COALESCE(
        SUM(
            TIMESTAMPDIFF(
                MINUTE,
                ta.TIMEIN,
                ta.TIMEOUT
            )
        ) / 60,
        0
    ) as remaining_hours
FROM 
    members_profile mp
LEFT JOIN 
    table_attendance ta ON mp.ID_NUMBER = ta.STUDENTID 
    AND ta.LOGDATE >= ? 
    AND ta.LOGDATE <= ?
    AND ta.TIMEOUT IS NOT NULL
GROUP BY 
    mp.USER_ID, mp.NAME, mp.ID_NUMBER, mp.TITLE, mp.EMAIL_ADD  -- Include EMAIL_ADD in GROUP BY
HAVING 
    remaining_hours > 0
ORDER BY 
    remaining_hours DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$monthStart, $monthEnd]);
$unfulfilled = $stmt->fetchAll();
?>

<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="unfulfilledTable">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>ID Number</th>
            <th>Title</th>
            <th>Email Address</th>
            <th>Current Hours</th>
            <th>Required Hours</th>
            <th>Remaining Hours</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($unfulfilled)): ?>
            <?php foreach ($unfulfilled as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['NAME']); ?></td>
                    <td><?php echo htmlspecialchars($user['ID_NUMBER']); ?></td>
                    <td><?php echo htmlspecialchars($user['TITLE']); ?></td>
                    <td><?php echo htmlspecialchars($user['EMAIL_ADD']); ?></td>
                    <td><?php echo number_format($user['total_hours'], 2); ?></td>
                    <td><?php echo htmlspecialchars($user['required_hours']); ?></td>
                    <td class="text-danger fw-bold"><?php echo number_format($user['remaining_hours'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">All users have fulfilled their monthly duty requirements.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {

        var table = $('#unfulfilledTable').DataTable({
            lengthChange: false,
            pageLength: 5,
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
    });

    table.buttons().container().appendTo('#unfulfilledTable_wrapper .col-md-6:eq(0)');
</script>