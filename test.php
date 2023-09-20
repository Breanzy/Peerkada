<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="css/customStyle.css">
    <link href="css/styles.css" rel="stylesheet">
    


</head>


<body>
    <!-- <span>
        <p class="text-center display-1 text-warning bg-dark rounded-4 table-hover">Hello World!</p>
    </span>

    <table class="table table-bordered table-striped table-hover">
        <tr class="
        ">
            <td>John</td>
            <td>Doe</td>
            <td>john@example.com</td>
        </tr>
        <tr class="
        ">
            <td>Mary</td>
            <td>Moe</td>
            <td>mary@example.com</td>
        </tr>
        <tr class="
        ">
        
            <td>July</td>
            <td>Dooley</td>
            <td>july@example.com</td>
        </tr>
    </table>

    <img src="icon.ico">

    <div class="container">
        <div class="row">
            <div class="col-4" style="color:blue;">test</div>
            <div class="col-2" style="color:red;">test</div>
            <div class="col-3" style="color:orange;">test</div>
            <div class="col-3" style="color:green;">test</div>
        </div>

        <div class="row">
            <div class="col-4" style="color:blue;">test</div>
            <div class="col-2" style="color:red;">test</div>
            <div class="col-3" style="color:orange;">test</div>
            <div class="col-3" style="color:green;">test</div>
        </div>

        <div class="row">
            <div class="col-4" style="color:blue;">test</div>
            <div class="col-2" style="color:red;">test</div>
            <div class="col-3" style="color:orange;">test</div>
            <div class="col-3" style="color:green;">test</div>
        </div>
    </div> -->

    <?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qrcode";
    $conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

    $test1 = 0;
    $test1 += (int)'1';
    $test1 += "1";

    $test2 = 3.5;

    $test1 /= ($test2)*100;

    echo $test2;


    // $sql = "UPDATE members_profile SET DUTYHOUR = 12 WHERE TITLE = 'Junior'";
    // $sql = "SELECT * FROM table_dutytotal WHERE STUDENTID = '$SchoolID'";
    // $query = $conn->query($sql);
    // $TotalDutyTime = 0;

    // $sql = "INSERT INTO table_dutytotal(STUDENTID, LOGDATE, TOTAL_DUTY_TIME) VALUES('$SchoolID', '$month', '$sessionTime')";

    // while ($row = $query->fetch_assoc()){
    //     // $TotalDutyTime += $row['TOTAL_DUTY_TIME']; 
    //     echo $row['TOTAL_DUTY_TIME'];
    // }

    // if($conn->query($sql) === TRUE){
    //     echo "deed haz been doone";} 
    
    ?>

</body>