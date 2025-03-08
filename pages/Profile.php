<?php
session_start();
ob_start(); // Start output buffering
require_once '../config.php';

// Check if Session ID is set
if (!isset($_SESSION['ID_Number'])) {
    // If not set, redirect to login page
    header('Location: login.php');
    exit();
}

// Check if the ID is valid
$SchoolID = $_SESSION['ID_Number'];

// Fetch profile information
$stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :id");
$stmt->execute(['id' => $SchoolID]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = 'ID Does not exist';
    header("Location: ../pages/login.php");
    exit();
}

if ($row) {
    $Name = $row['NAME'];
    $Title = $row['TITLE'];
    $College = $row['COLLEGE'];
    $SchoolYr = $row['SCHOOL_YR'];
    $Course = $row['COURSE'];
    $Email = $row['EMAIL_ADD'];
    $Number = $row['PHONE_NUM'];
    $Address = $row['ADDRESS'];
    $Birth = $row['BIRTH'];
    $Sex = $row['SEX'];
    //Duty hour requirement per month
    switch ($Title) {
        case 'Assistant':
            $DutyHour = 16;
            break;
        case 'Junior':
            $DutyHour = 12;
            break;
        case 'Senior':
            $DutyHour = 10;
            break;
        case 'LAV':
            $DutyHour = 20;
            break;
        default:
            $DutyHour = 0;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Profile</title>
</head>

<body class="sb-nav-fixed">
    <?php include('../components/TopNav.php'); ?>

    <div id="layoutSidenav">
        <?php include('../components/SideNav.php'); ?>

        <!-- MAIN CONTENT -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-5">

                    <!-- User Details -->
                    <?php include('../components/ProfileDetail.php'); ?>

                    <!-- Duty Hours Rendered -->
                    <?php include('../components/ProfileDutyRendered.php'); ?>

                    <!-- Duty Logs -->
                    <div class="row mt-5">
                        <div class="col-xl">
                            <h2 class="text-center fw-bolder">Duty Logs</h2>
                            <?php

                            $tableID = 'profileID';
                            $query = "SELECT * FROM table_attendance WHERE STUDENTID = '$SchoolID' AND TIMEOUT IS NOT NULL ORDER BY ATTENDANCE_ID DESC";
                            include '../components/TableAttendance.php';
                            ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl">
                            <button id="editProfileBtn" class="btn btn-primary me-2">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </button>
                            <?php include('../components/EditUserModal.php'); ?>
                            <script src="../js/EditUserScript.js"></script>

                            <button id="downloadQrCode" class="btn btn-primary">
                                <i class="fas fa-qrcode"></i> Download QR Code
                            </button>

                            <button id="resetPasswordBtn" class="btn btn-primary">
                                <i class="fas fa-key"></i> Reset Password
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

<?php include('../components/ResetPasswordModal.php'); ?>
<script src="../js/ResetPasswordScript.js"></script>

<script>
    document.getElementById('downloadQrCode').addEventListener('click', function() {
        // Create a form and submit it to trigger the download
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
        userIdInput.value = '<?php echo $SchoolID; ?>';

        form.appendChild(actionInput);
        form.appendChild(userIdInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    document.getElementById('editProfileBtn').addEventListener('click', function() {
        // Prepare user data from PHP variables
        const userData = {
            userId: '<?php echo $row['USER_ID']; ?>',
            name: '<?php echo $Name; ?>',
            idNumber: '<?php echo $SchoolID; ?>',
            title: '<?php echo $Title; ?>',
            college: '<?php echo $College; ?>',
            schoolYear: '<?php echo $SchoolYr; ?>',
            course: '<?php echo $Course; ?>',
            email: '<?php echo $Email; ?>',
            phone: '<?php echo $Number; ?>',
            address: '<?php echo addslashes($Address); ?>',
            birthDate: '<?php echo $Birth; ?>',
            sex: '<?php echo $Sex; ?>'
        };

        // Load and show modal
        userEditModal.loadUserData(userData);
        userEditModal.showModal();
    });

    document.getElementById('resetPasswordBtn').addEventListener('click', function() {
        // Show the reset password modal for the current user
        resetPasswordModal.showModal('<?php echo $SchoolID; ?>', '<?php echo $Name; ?>');
    });
</script>