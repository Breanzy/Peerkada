<?php session_start(); ?>
<?php

// INITIALIZING
$server = "localhost";
$username = "root";
$password = "";
$dbname = "id21827628_peerkada";
$conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");


$ID_Number = $_POST['ID_Number'];
$User_Password = $_POST['User_Password'];
$conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

//CHECKS IF THE INPUT ID NUMBER EXISTS IN THE PROFILE DB.
$sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$ID_Number'";
$query = $conn->query($sql);

if ($query->num_rows > 0) {
    // CHECKS IF PASSWORD IS CORRECT.
    // P.S. I think this process could be optimized by using the $query result instead of just creating a new request
    $sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$ID_Number' AND PASSWORD = '$User_Password'";
    $query = $conn->query($sql);

    if ($query->num_rows > 0) {
        // SETS SESSION 'name' TO THE ID NUMBER OF USER AND GOES TO MAIN DASHBOARD
        $_SESSION['name'] = $ID_Number;
        header("location: index.php");

    } else {
        $_SESSION['error'] = 'Incorrect Password!';
        header("location: login.php");
    }

} else {
    $_SESSION['error'] = 'No Such Member ID Number exist!';
    header("location: login.php");
}

$conn->close();
?>