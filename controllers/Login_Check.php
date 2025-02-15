<?php

session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_number = $_POST['ID_Number'];
    $password = $_POST['User_Password'];

    $stmt = $pdo->prepare("SELECT * FROM members_profile WHERE ID_NUMBER = :id_number");
    $stmt->execute(['id_number' => $id_number]);
    $user = $stmt->fetch();

    // Check if user exists or password is correct
    if ($user && password_verify($password, $user['PASSWORD'])) {
        // SETS SESSION 'name' TO THE ID NUMBER OF USER AND GOES TO MAIN DASHBOARD
        $_SESSION['name'] = $user['NAME'];
        $_SESSION['ID_Number'] = $user['ID_NUMBER'];
        $_SESSION['isAdmin'] = $user['IS_ADMIN'];
        $_SESSION['success'] = 'Logged in Successfully!';
        header("location: ../pages/index.php");
    } else {
        $_SESSION['error'] = 'Incorrect Password / User does not exist. Please try again.';
        header("location: ../pages/login.php");
    }
    exit();
} else {
    header("location: ../pages/login.php");
    exit();
}
