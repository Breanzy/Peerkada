<?php session_start(); ?>
<?php

    // INITIALIZING
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "id21827628_peerkada";
    $conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

    $text = $_POST['text'];

    //CHECKS IF THE INPUT ID NUMBER EXISTS IN THE PROFILE DB
    $sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$text'";
    $query = $conn->query($sql);
    
    if($query->num_rows>0){
        // SET TIMEZONE TO ASIA FOR SYNCHRONIZED TIME RECORDING
        date_default_timezone_set("Asia/Singapore");
        $date = date('d-m-Y');
        $time = date('His');

        // CHECKS IF THERE ARE UNCLOSED TIME-IN LOGS FOR THIS PARTICULAR ID NUMBER
        $sql = "SELECT * FROM table_attendance WHERE STUDENTID = '$text' AND LOGDATE = '$date' AND STATUS = '0'";
        $query = $conn->query($sql);
        //IF TRUE, UPDATE NEW TIME OUT LOG AND ADD TOTAL TIME TO TOTAL TIME DB
        if($query->num_rows>0){

            // CLACULATES TOTAL TIME
            $sessionTime = 0;
            while ($row = $query->fetch_assoc()){
                $sessionTime = (int)$time - (int)$row['TIMEIN'];
            }

            // PLACE RELEVANT DATA IN RESPECTIVE TABLES
            $sql = "UPDATE table_attendance SET TIMEOUT = '$time', STATUS='1', TOTALTIME = '$sessionTime' WHERE STUDENTID='$text' AND LOGDATE='$date' AND STATUS='0'";
            $query = $conn->query($sql);
            
            $month = date('m-Y');
            $sql = "SELECT * FROM table_dutytotal WHERE STUDENTID =  $text AND LOGDATE = '$month'";
            $query = $conn->query($sql);

            if($query->num_rows>0){

                $totalTime = 0;
                while ($row = $query->fetch_assoc()){
                    $totalTime += $row['TOTAL_DUTY_TIME'];
                }
                $totalTime += $sessionTime;

                $sql = "UPDATE table_dutytotal SET TOTAL_DUTY_TIME = '$totalTime' WHERE STUDENTID='$text' AND LOGDATE='$month'";
                $query = $conn->query($sql);

            }else{

                $sql = "INSERT INTO table_dutytotal(STUDENTID, LOGDATE, TOTAL_DUTY_TIME) VALUES('$text', '$month', '$sessionTime')";
                $query = $conn->query($sql);
            }

            
            $_SESSION['success'] = "Successfully Signed Out!";
        } else{
            // IF FALSE, CREATE A NEW UNCLOSED TIME-IN LOG
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
    }
    
    header("location: index.php");
    $conn->close();
?>