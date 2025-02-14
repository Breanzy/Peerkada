<?php
// Function to calculate total duty time
function calculateDutyTime($pdo, $SchoolID, $month = null)
{
    $query = "SELECT TIMEIN, TIMEOUT FROM table_attendance WHERE STUDENTID = :id AND TIMEOUT IS NOT NULL";
    if ($month) {
        $query .= " AND DATE_FORMAT(LOGDATE, '%Y-%m') = :logdate";
    }

    $stmt = $pdo->prepare($query);
    $params = ['id' => $SchoolID];
    if ($month) {
        $params['logdate'] = $month;
    }
    $stmt->execute($params);

    $totalDutyTime = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $signIn = strtotime($row['TIMEIN']);
        $signOut = strtotime($row['TIMEOUT']);

        if ($signIn && $signOut) {
            $totalDutyTime += ($signOut - $signIn);
        }
    }
    return round(($totalDutyTime / 3600), 2); // Convert seconds to hours
}

// Get the current month in 'Y-m' format
$currentMonth = date('Y-m');

// Calculate monthly and total duty time
$MonthlyDutyTime = calculateDutyTime($pdo, $SchoolID, $currentMonth);
$TotalDutyTime = calculateDutyTime($pdo, $SchoolID);

?>

<!-- Changing card color depending on threshold -->
<?php
// Constants for percentage thresholds
define('LOW_THRESHOLD', 33.33);
define('HIGH_THRESHOLD', 66.67);

// Calculate required duty hours per week
$requiredDutyPerWeek = $DutyHour / 4;

// Calculate monthly duty percentage
$monthlyPercent = ($DutyHour > 0) ? ($MonthlyDutyTime / $DutyHour) * 100 : 0;

// Determine card color based on monthly percentage
$cardColor = ($monthlyPercent < LOW_THRESHOLD) ? "danger" : (($monthlyPercent > HIGH_THRESHOLD) ? "success" : "warning");
?>

<div class="row justify-content-evenly mt-5">
    <div class="col-xl-3 col-md-10 shadow rounded-3 p-3 alert d-flex justify-content-center align-items-center">
        <div class="count-data text-center">
            <h6 class="fw-bold fs-2"><?php echo htmlspecialchars($requiredDutyPerWeek); ?> Hours</h6>
            <p class="m-0px font-w-600">Required Duty Per Week</p>
        </div>
    </div>

    <div class="col-xl-3 col-md-10 shadow alert alert-<?php echo htmlspecialchars($cardColor); ?> rounded-3 p-3 d-flex justify-content-center align-items-center">
        <div class="count-data text-center hover-overlay">
            <h6 class="fw-bold fs-2"><?php echo htmlspecialchars($MonthlyDutyTime); ?> / <?php echo htmlspecialchars($DutyHour); ?></h6>
            <p class="m-0px font-w-600">Monthly Duty Hours Rendered</p>

            <div class="progress mb-2">
                <div class="progress-bar bg-<?php echo htmlspecialchars($cardColor); ?> progress-bar-striped progress-bar-animated"
                    role="progressbar" style="width: <?php echo htmlspecialchars($monthlyPercent); ?>%" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="text-white col-xl-3 col-md-10 shadow rounded-3 p-3 alert bg-dark d-flex justify-content-center align-items-center">
        <div class="count-data text-center">
            <h6 class="fw-bold fs-2"><?php echo htmlspecialchars($TotalDutyTime); ?></h6>
            <p class="m-0px font-w-600">Overall Duty Hours Rendered</p>
        </div>
    </div>
</div>