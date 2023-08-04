<?php session_start(); ?>
<!-- ayaw nalang paghimog totaldate i tally nalang sila sa pikas na panel jud para mas dali -->
<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qrcode";

    $text = $_POST['text'];
    $conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

    $sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$text'";
    $query = $conn->query($sql);
    
    if($query->num_rows>0){
        
        date_default_timezone_set("Asia/Singapore");
        $date = date('d-m-Y');
        $time = date('His');

        echo $time;

        $sql = "SELECT * FROM table_attendance WHERE STUDENTID = '$text' AND LOGDATE = '$date' AND STATUS = '0'";
        
        if($conn->query($sql)->num_rows>0){

            $sql = "UPDATE table_attendance SET TIMEOUT = '$time', STATUS='1' WHERE STUDENTID='$text' AND LOGDATE='$date' AND STATUS='0'";
            $query = $conn->query($sql);
            
            $_SESSION['success'] = "Successfully Signed Out!";
        } else{

            $sql = "INSERT INTO table_attendance(STUDENTID, TIMEIN, LOGDATE, STATUS) VALUES('$text', '$time', '$date', '0')";
            if($conn->query($sql) === TRUE){
                $_SESSION['success'] = "Successfully Signed In!";
            } else {
                $_SESSION['error'] = $conn->error;
            }
        }

    }

    else{
        $_SESSION['error'] = 'No Such Member ID exist!!';
        // $_SESSION['error'] = $text;
    }

    header("location: index.php");
    $conn->close();
?>