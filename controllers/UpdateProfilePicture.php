<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID_Number'])) {
    $errorMessage = urlencode("You must be logged in to change your profile picture.");
    header("Location: ../pages/login.php?error=" . $errorMessage);
    exit();
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['school_id'])) {
    $schoolID = $_POST['school_id'];

    // Security check - verify that the logged-in user is changing their own picture
    if ($_SESSION['ID_Number'] != $schoolID) {
        $errorMessage = urlencode("You can only change your own profile picture.");
        header("Location: ../pages/Profile.php?error=" . $errorMessage);
        exit();
    }

    // Check if file was uploaded
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
            $new_filename = $schoolID . '.' . $file_ext;
            $destination = $upload_dir . $new_filename;

            // Check for existing files with different extensions and remove them
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            foreach ($extensions as $ext) {
                $existing_file = $upload_dir . $schoolID . '.' . $ext;
                if (file_exists($existing_file) && $existing_file != $destination) {
                    unlink($existing_file); // Delete the old file
                }
            }

            // Move the uploaded file to our directory
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destination)) {
                $successMessage = urlencode("Profile picture updated successfully!");
                header("Location: ../pages/Profile.php?success=" . $successMessage);
            } else {
                $errorMessage = urlencode("Failed to upload profile picture.");
                header("Location: ../pages/Profile.php?error=" . $errorMessage);
            }
        } else {
            $errorMessage = urlencode("Invalid file format. Only JPG, JPEG, PNG and GIF are allowed.");
            header("Location: ../pages/Profile.php?error=" . $errorMessage);
        }
    } else {
        $errorMessage = urlencode("No file was uploaded or an error occurred.");
        header("Location: ../pages/Profile.php?error=" . $errorMessage);
    }
    exit();
} else {
    $errorMessage = urlencode("Invalid request.");
    header("Location: ../pages/Profile.php?error=" . $errorMessage);
    exit();
}
