<?php session_start();
require_once '../config.php';

if ($_SESSION['role'] != 'admin') {
    // If not set, redirect to login page
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Admin Dashboard</title>
</head>

<body class="sb-nav-fixed bg-light">
    <?php require_once('../components/TopNav.php'); ?>

    <div id="layoutSidenav">
        <?php require_once('../components/SideNav.php'); ?>
        <?php require_once '../components/Notifications.php'; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 d-flex flex-column gap-4">
                    <div class="">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Admin Controls</li>
                        </ol>
                    </div>

                    <?php
                    // Get statistics
                    $totalUsers = $pdo->query("SELECT COUNT(*) FROM members_profile WHERE ROLE = 'user'")->fetchColumn();
                    $totalAttendanceLogs = $pdo->query("SELECT COUNT(*) FROM table_attendance")->fetchColumn();

                    // Get database size
                    function getTableSize($pdo, $tableName)
                    {
                        $query = "SELECT 
                                    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb 
                                FROM 
                                    information_schema.TABLES 
                                WHERE 
                                    table_schema = DATABASE() 
                                AND 
                                    table_name = :table";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute(['table' => $tableName]);
                        return $stmt->fetchColumn();
                    }

                    $userTableSize = getTableSize($pdo, 'members_profile');
                    $attendanceTableSize = getTableSize($pdo, 'table_attendance');
                    $totalDatabaseSize = $userTableSize + $attendanceTableSize;

                    // Get assets folder size
                    function getFolderSize($path)
                    {
                        $totalSize = 0;
                        $files = scandir($path);
                        foreach ($files as $file) {
                            if ($file !== '.' && $file !== '..') {
                                if (is_dir($path . '/' . $file)) {
                                    $totalSize += getFolderSize($path . '/' . $file);
                                } else {
                                    $totalSize += filesize($path . '/' . $file);
                                }
                            }
                        }
                        return $totalSize;
                    }

                    $assetsSize = 0;
                    $assetsPath = '../assets';
                    if (file_exists($assetsPath) && is_dir($assetsPath)) {
                        $assetsSize = getFolderSize($assetsPath);
                    }
                    $assetsSizeMB = round($assetsSize / (1024 * 1024), 2);
                    $assetsSizeGB = $assetsSizeMB / 1024;
                    $assetsMaxSizeGB = 5; // 5GB max limit
                    $assetsPercentage = ($assetsSizeGB / $assetsMaxSizeGB) * 100;

                    // Determine progress bar color based on percentage
                    $progressBarColor = 'bg-success';
                    if ($assetsPercentage > 75) {
                        $progressBarColor = 'bg-danger';
                    } elseif ($assetsPercentage > 50) {
                        $progressBarColor = 'bg-warning';
                    }
                    ?>

                    <!-- Statistics Dashboard -->
                    <div class="row d-flex gap-2 justify-content-center items-align-center">
                        <div class="col-xl-2 col-md-6">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs text-white-50 text-uppercase mb-1">Total Users</div>
                                            <div class="h3 mb-0 font-weight-bold"><?php echo number_format($totalUsers); ?></div>
                                        </div>
                                        <div>
                                            <i class="fas fa-users fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs text-white-50 text-uppercase mb-1">Total Attendance Logs</div>
                                            <div class="h3 mb-0 font-weight-bold"><?php echo number_format($totalAttendanceLogs); ?></div>
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs text-white-50 text-uppercase mb-1">Database Size</div>
                                            <div class="h3 mb-0 font-weight-bold"><?php echo number_format($totalDatabaseSize, 2); ?> MB</div>
                                            <div class="small mt-1 text-white-50">
                                                Users: <?php echo number_format($userTableSize, 2); ?> MB |
                                                Logs: <?php echo number_format($attendanceTableSize, 2); ?> MB
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-database fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs text-white-50 text-uppercase mb-1">Assets Folder Size</div>
                                            <div class="h3 mb-0 font-weight-bold"><?php echo number_format($assetsSizeGB, 2); ?> GB</div>
                                            <div class="small mt-1 text-white-50">
                                                Max limit: <?php echo $assetsMaxSizeGB; ?> GB
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-folder-open fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar <?php echo $progressBarColor; ?>" role="progressbar"
                                                style="width: <?php echo $assetsPercentage; ?>%;"
                                                aria-valuenow="<?php echo $assetsPercentage; ?>"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="small mt-1 text-center text-white-50">
                                            <?php echo number_format($assetsPercentage, 1); ?>% of limit used
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Statistics Dashboard -->

                    <!-- Users Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-users me-1"></i>
                                    Users
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            // Fetch users
                            $query = "SELECT * FROM members_profile WHERE ROLE = 'user'";
                            require_once '../components/TableUsers.php';
                            ?>
                        </div>
                    </div>

                    <!-- Attendance Logs Sections -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Attendance Logs (Signed Out)
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Fetch attendance logs where TIMEOUT is not null
                                    $tableID = 'signedOut';
                                    $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NOT NULL ";
                                    require '../components/TableAttendance.php';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Attendance Logs (Missing Sign Out)
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Fetch attendance logs where TIMEOUT is null
                                    $tableID = 'notSignedOut';
                                    $query = "SELECT * FROM table_attendance WHERE TIMEOUT IS NULL";
                                    require '../components/TableAttendance.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unfulfilled Monthly Duties -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-tasks me-1"></i>
                            Unfulfilled Monthly Duties
                        </div>
                        <div class="card-body">
                            <?php require '../components/TableUnfulfilledDuty.php'; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>

</html>