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

    // Profile picture handling
    $profile_picture = "default.jpg"; // Default image in case no upload

    // Check if profile picture was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_picture']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Validate file extension
        if (in_array($file_ext, $allowed)) {
            // Create directory if it doesn't exist
            $upload_dir = "../assets/ProfilePictures/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Set the new filename to the user's School ID
            $new_filename = $SchoolID . '.' . $file_ext;
            $destination = $upload_dir . $new_filename;

            // Move the uploaded file to our directory
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destination)) {
                $profile_picture = $new_filename;
            } else {
                $warningMessage = "Error uploading profile picture. Using default.";
            }
        } else {
            $warningMessage = "Invalid file format. Only JPG, JPEG, PNG and GIF are allowed.";
        }
    }

    // Check if ID Number already exists in the database
    require '../config.php';
    $stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :SchoolID");
    $stmt->execute(['SchoolID' => $SchoolID]);

    if ($stmt->rowCount() > 0) {
        // Registered Profile already exists
        $errorMessage = urlencode("ID Number Already Exist in the Database!");
        header("location: ../pages/login.php?error=" . $errorMessage);
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
                // Set success message for sweet alert
                $successMsg = "Successfully registered!";
?>
                <!DOCTYPE html>
                <html>

                <head>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        // Show success message right away
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '<?php echo $successMsg; ?>',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    </script>
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

                                    // Redirect to login page after a short delay with success message
                                    setTimeout(() => {
                                        window.location.href = "../pages/login.php?success=" + encodeURIComponent("Successfully registered! You can now log in.");
                                    }, 1000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Error generating QR code: ' + result.error,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });

                                    setTimeout(() => {
                                        window.location.href = "../pages/login.php";
                                    }, 2000);
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error generating QR code',
                                    timer: 3000,
                                    timerProgressBar: true
                                });

                                setTimeout(() => {
                                    window.location.href = "../pages/login.php";
                                }, 2000);
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
            $errorMessage = urlencode("Error: " . $e->getMessage());
            header("location:../pages/register.php?error=" . $errorMessage);
            exit();
        }
    }
} else {
    header("location:../pages/register.php");
    exit();
}
