<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>    

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        font-family: 'Roboto Slab', serif;
        <title>Dashboard - SB Admin</title>

        <!-- bootstrap style  -->
        <link href="css/styles.css" rel="stylesheet">

        <!-- para sa mga icons -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="js/listhingy.js"></script>
        <script src= https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js></script>
    </head>

    <body class="sb-nav-fixed">
        <?php include('TopNav.php');?>

        <div id="layoutSidenav">
            <?php include('SideNav.php');?>

            <!-- MAIN CONTENT -->
            <div id="layoutSidenav_content">
                <main>
                    <div class = "container-fluid p-5">
                        <div class= "row">
                            <div class="col-xl-4 p-2">
                                <img src="testt.jpg" class="img-fluid rounded-circle mx-auto d-block" alt="Image" style="height: 50%;">
                            </div>
     
                            <div class="col-xl-8 col-md-12 center-align text-lg-start text-center">

                                <?php
                                    // INITIALIZING FOR PROFILE INFORMATION
                                    $server = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "qrcode";
                                    $conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

                                    // SCHOOL ID INITIALIZED ALREADY THROUGH "name" SESSION
                                    $SchoolID = $_SESSION['name'];

                                    $sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$SchoolID'";
                                    $query = $conn->query($sql);

                                    while ($row = $query->fetch_assoc()){
                                    
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
                                        $DutyHour = $row['DUTYHOUR'];
                                    }

                                    // GET MONTHLY DUTY TIME RENDERED
                                    // P.S I think this code can also be optimized somehow with the total duty time, idk.
                                    $MonthDate = date('m-Y');
                                    $sql = "SELECT * FROM table_dutytotal WHERE STUDENTID = '$SchoolID' AND LOGDATE = '$MonthDate'";
                                    $query = $conn->query($sql);
                                    $MonthlyDutyTime = 0;

                                    while ($row = $query->fetch_assoc()){
                                        $MonthlyDutyTime = (int)$row['TOTAL_DUTY_TIME'];
                                    }

                                    // GET TOTAL DUTY TIME RENDERED
                                    $sql = "SELECT * FROM table_dutytotal WHERE STUDENTID = '$SchoolID'";
                                    $query = $conn->query($sql);
                                    $TotalDutyTime = 0;

                                    while ($row = $query->fetch_assoc()){
                                        $TotalDutyTime += (int)$row['TOTAL_DUTY_TIME'];
                                    }                                    

                                    // CONVERT SECONDS TO HOURS
                                    $TotalDutyTime /= 3600;
                                    $MonthlyDutyTime /= 3600;

                                ?>
              
                                <h3 class="fw-bold fs-1"><?php echo $Name; ?></h3>
                                <h6 class="theme-color lead"><?php echo $Title; ?></h6>
                                <br>
                                <div class="row about-list">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="media">
                                            <label class="fw-bold">Birthday</label>
                                            <p><?php echo $Birth; ?></p>
                                        </div>
                                        <div class="media">
                                            <label class="fw-bold">Address</label>
                                            <p><?php echo $Address; ?></p>
                                        </div>

                                        <div class="media">
                                            <label class="fw-bold">E-mail</label>
                                            <p><?php echo $Email; ?></p>
                                        </div>
                                        <div class="media">
                                            <label class="fw-bold">Phone</label>
                                            <p><?php echo $Number; ?></p>

                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <div class="media">
                                            <label class="fw-bold">School ID</label>
                                            <p><?php echo $SchoolID; ?></p>
                                        </div>
                                        <div class="media">
                                            <label class="fw-bold">College</label>
                                            <p><?php echo $College; ?></p>
                                        </div>
                                        <div class="media">
                                            <label class="fw-bold">Course</label>
                                            <p><?php echo $Course; ?></p>
                                        </div>
                                        <div class="media">
                                            <label class="fw-bold">School Year</label>
                                            <p><?php echo $SchoolYr; ?></p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-evenly">

                            <div class="col-xl-3 col-md-10 shadow rounded-3 p-3 alert">
                                <div class="count-data text-center">
                                    <h6 class="fw-bold fs-2"> <?php echo $DutyHour/4; ?> Hours</h6>
                                    <p class="m-0px font-w-600">Required Duty Per Week</p>
                                </div>
                            </div>


                            <!-- Krazy garbage code, but it works. I hate it. It is for changing card color depending on value -->
                            <?php 
                                $MonthlyPercent = ($MonthlyDutyTime / $DutyHour)*100;

                                if($MonthlyPercent < 100/3){$CardColor = "danger";}
                                else if($MonthlyPercent > 200/3){$CardColor = "success";} 
                                else{$CardColor = "warning";} 
                            ?>

                            <div class="col-xl-3 col-md-10 shadow alert alert-<?php echo $CardColor;?> rounded-3 p-3">
                                <div class="count-data text-center hover-overlay">
                                    <h6 class="fw-bold fs-2"> <?php echo $MonthlyDutyTime; ?> / <?php echo $DutyHour; ?> </h6>
                                    <p class="m-0px font-w-600">Monthly Duty Hours Rendered</p>


                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-<?php echo $CardColor; ?> progress-bar-striped progress-bar-animated" 
                                        role="progressbar" style="width: <?php echo $MonthlyPercent; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                </div>
                            </div>

                            <div class="text-white col-xl-3 col-md-10 shadow rounded-3 p-3 alert bg-dark">
                                <div class="count-data text-center">
                                    <h6 class="fw-bold fs-2"> <?php echo $TotalDutyTime; ?> </h6>
                                    <p class="m-0px font-w-600">Overall Duty Hours Rendered</p>
                                </div>
                            </div>
                        </div>

                        <div class = "row">
                            <div class = "col-xl" >
                                <h2 class="text-center">Duty Logs</h2>
                                <table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden example">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Student ID</th>
                                            <th scope="col">Log Date</th>
                                            <th scope="col">Time In</th>
                                            <th scope="col">Time Out</th>
                                            <th scope="col">Total Time</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        date_default_timezone_set("Asia/Singapore");
                                        $DATE = date('d-m-Y');

                                        $sql ="SELECT * FROM table_attendance WHERE STUDENTID = $SchoolID AND STATUS = 1 ORDER BY ATTENDANCE_ID DESC";
                                        $query = $conn->query($sql);
                                        
                                        while ($row = $query->fetch_assoc()){
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $row['STUDENTID'];?></td>
                                                <td><?php echo $row['LOGDATE'];?></td>
                                                <td><?php echo ($row['TIMEIN'] != null) ? date('h:i:s A', strtotime($row['TIMEIN'])) : null;?></td>
                                                <td><?php echo ($row['TIMEOUT'] != null) ? date('h:i:s A', strtotime($row['TIMEOUT'])) : null;?></td>
                                                <td><?php echo ($row['TIMEOUT'] != null) ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", (int)$row['TIMEOUT'] - (int)$row['TIMEIN']): null ;?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="js/scripts.js"></script>

        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript"></script>                    
    </body>
</html>
