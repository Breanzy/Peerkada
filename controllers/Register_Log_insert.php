<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Form Contents
    $Name = $_POST['Name'];
    $SchoolID = $_POST['SchoolID'];
    $Title = $_POST['Title'];
    $College = $_POST['College'];
    $SchoolYr = $_POST['SchoolYr'];
    $Course = $_POST['Course'];
    $Email = $_POST['Email'];
    $Number = $_POST['Number'];
    $Address = $_POST['Address'];
    $Birth = $_POST['Birth'];
    $Sex = $_POST['Sex'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT);

    // Check if ID Number already exists in the database
    require '../config.php';
    $stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :SchoolID");
    $stmt->execute(['SchoolID' => $SchoolID]);

    if ($stmt->rowCount() > 0) {
        // Registered Profile already exists
        $_SESSION['error'] = "ID Number Already Exist in the Database!";
        header("location: ../pages/login.php");
        exit();
    } else {
        // Proceed with function
        $stmt = $pdo->prepare(
            "INSERT INTO members_profile 
            (NAME, ID_NUMBER, TITLE, COLLEGE, SCHOOL_YR, COURSE, EMAIL_ADD, PHONE_NUM, ADDRESS, BIRTH, SEX, PASSWORD) 
            VALUES (:Name, :SchoolID, :Title, :College, :SchoolYr, :Course, :Email, :Number, :Address, :Birth, :Sex, :Password)"
        );

        try {
            if ($stmt->execute([
                ':Name' => $Name,
                ':SchoolID' => $SchoolID,
                ':Title' => $Title,
                ':College' => $College,
                ':SchoolYr' => $SchoolYr,
                ':Course' => $Course,
                ':Email' => $Email,
                ':Number' => $Number,
                ':Address' => $Address,
                ':Birth' => $Birth,
                ':Sex' => $Sex,
                ':Password' => $Password,
            ])) {
                $_SESSION['success'] = "Successfully registered!";
?>
                <!DOCTYPE html>
                <html>

                <head>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                </head>

                <body>
                    <script>
                        // Generate QR code using AJAX
                        $.ajax({
                            url: '../controllers/QRCodeAPI.php',
                            method: 'POST',
                            data: {
                                action: 'generate',
                                userId: '<?php echo $SchoolID; ?>',
                                name: '<?php echo $Name; ?>'
                            },
                            success: function(response) {
                                const result = JSON.parse(response);
                                if (result.success) {
                                    // Trigger QR code download
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

                                    // Redirect to login page after a short delay
                                    setTimeout(() => {
                                        window.location.href = "../pages/login.php";
                                    }, 1000);
                                } else {
                                    alert('Error generating QR code: ' + result.error);
                                    window.location.href = "../pages/login.php";
                                }
                            },
                            error: function() {
                                alert('Error generating QR code');
                                window.location.href = "../pages/login.php";
                            }
                        });
                    </script>
                </body>

                </html>
<?php
            } else {
                throw new Exception($stmt->errorInfo()[2]);
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("location:../pages/register.php");
            exit();
        }
    }
} else {
    header("location:../pages/register.php");
    exit();
}
?>