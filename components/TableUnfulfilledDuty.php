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
    mp.USER_ID, mp.NAME, mp.ID_NUMBER, mp.TITLE  -- in GROUP BY
HAVING 
    remaining_hours > 0
ORDER BY 
    remaining_hours DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$monthStart, $monthEnd]);
$unfulfilled = $stmt->fetchAll();
?>

<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden w-100" id="unfulfilledTable">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>ID Number</th>
            <th>Title</th>
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

<button id="sendWarningEmail" class="btn btn-danger">Send Duty Warning Emails</button>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#unfulfilledTable').DataTable({
            lengthChange: false,
            pageLength: 5,
            autoWidth: true,
            responsive: true,
            scrollX: true,
            columnDefs: [{
                className: 'text-center',
                targets: '_all',
                width: '1%',
            }]
        });

        // Append buttons to the correct location
        table.buttons().container().appendTo('#unfulfilledTable_wrapper .col-md-6:eq(0)');

        // Handle email button click
        $('#sendWarningEmail').on('click', function() {
            if (confirm('Are you sure you want to send warning emails to all unfulfilled users?')) {
                // Show loading state
                $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

                $.ajax({
                    url: '../controllers/Mailer_SendDutyWarning.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message
                            });
                        } else {
                            let errorMsg = response.message;
                            if (response.errors) {
                                errorMsg += '\nDetails:\n' + response.errors.map(e => `${e.email}: ${e.message}`).join('\n');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMsg
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to send emails: ' + error
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $('#sendWarningEmail').prop('disabled', false).html('Send Duty Warning Emails');
                    }
                });
            }
        });
    });
</script>