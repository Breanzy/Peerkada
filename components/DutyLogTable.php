<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="example">
    <thead class="table-dark">
        <tr>
            <th scope="col">Student ID</th>
            <th scope="col">Log Date</th>
            <th scope="col">Time In</th>
            <th scope="col">Time Out</th>
            <th scope="col">Total Time</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php

        // Check if the required parameters are set
        if (isset($stmt)) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $studentId = htmlspecialchars($row['STUDENTID']);
                $logDate = htmlspecialchars($row['LOGDATE']);
                $timeInTimestamp = strtotime($row['TIMEIN']);
                $timeOutTimestamp = $row['TIMEOUT'] ? strtotime($row['TIMEOUT']) : null;
                $timeIn = $row['TIMEIN'] ? date('h:i:s A', $timeInTimestamp) : null;
                $timeOut = $row['TIMEOUT'] ? date('h:i:s A', $timeOutTimestamp) : null;
                $totalTime = $row['TIMEOUT'] ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", $timeOutTimestamp - $timeInTimestamp) : null;

                echo "
                <tr>
                    <th scope='row'>{$studentId}</th>
                    <td>{$logDate}</td>
                    <td>{$timeIn}</td>
                    <td>{$timeOut}</td>
                    <td>{$totalTime}</td>
                    <td class='text-center'>
                        <a class='btn btn-warning fa-solid fa-pen-to-square m-1'></a>
                        <a class='btn btn-danger fa-solid fa-trash m-1'></a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
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

        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    });
</script>