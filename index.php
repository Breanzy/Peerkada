<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Dashboard - SB Admin</title>

        <!-- styles  -->
        <link href="css/styles.css" rel="stylesheet">
        <link rel="stylesheet" href="css/customStyle.css">


        <!-- FOR BUTTON FUNCTIONALITIES -->
        <script src="js/scripts.js"></script>

        <!-- para sa mga icons -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- para camera thingy -->
        <script type = "text/javascript" src = "js/instascan.min.js"></script>
        
        <!-- para chada na table. Jesus It's a lot -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>        
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
        
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        

        <script src ="js/listhingy.js"></script>
        
    </head>

    <body class="sb-nav-fixed">
        <?php include('TopNav.php');?>

        <div id="layoutSidenav">
            <?php include('SideNav.php');?>

            <!-- THE WHOLE CONTENT -->
            <div id="layoutSidenav_content">
                <main>
                    <div class = "container-fluid p-4">
                        <div class = "row">
                            
                            <div class="col-xl-5 col-lg-6 col-md-10">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fa fa-camera " aria-hidden="true"></i>
                                        QR Scanner
                                    </div>

                                    <div class="card-body">
                                        <video id= "preview" class="rounded-3" width="100%"></video>
                                    </div>
                                </div>
                            </div>
   
                            <div class="col-xl-7 col-lg-6 col-md-10">
                            <?php
                                if(isset($_SESSION['error'])){
                                    echo "
                                    <div class='position-absolute top-0 end-0 alert alert-danger alert-dismissible fadee' style='background:red;color:#fff'>
                                        <h4><i class='icon fa fa-warning fadee'></i> Error!</h4>
                                        ".$_SESSION['error']."
                                    </div>
                                    ";
                                    unset($_SESSION['error']);
                                }
                                if(isset($_SESSION['success'])){
                                    echo "
                                    <div class='position-absolute top-0 end-0 alert alert-success alert-dismissible fadee' style='background:green;color:#fff'>
                                        <h4><i class='icon fa fa-check'></i> Success!</h4>
                                        ".$_SESSION['success']."
                                    </div>
                                    ";
                                    unset($_SESSION['success']);
                                }?>

                                <h1>Recent Logs</h1>
                                <table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden" id="example">
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
                                        $server = "localhost";
                                        $username="root";
                                        $password="";
                                        $dbname="qrcode";
                                        $conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

                                        
                                        date_default_timezone_set("Asia/Singapore");
                                        $DATE = date('d-m-Y');

                                        $sql ="SELECT * FROM table_attendance WHERE LOGDATE = '$DATE' ORDER BY ATTENDANCE_ID DESC limit 6";
                                        $query = $conn->query($sql);
                                        
                                        while ($row = $query->fetch_assoc()){
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $row['STUDENTID'];?></td>
                                                <td><?php echo $row['LOGDATE'];?></td>
                                                <td><?php echo ($row['TIMEIN'] != null) ? date('h:i:s A', strtotime($row['TIMEIN'])) : null;?></td>
                                                <td><?php echo ($row['TIMEOUT'] != null) ? date('h:i:s A', strtotime($row['TIMEOUT'])) : null;?></td>
                                                <td><?php echo ($row['TIMEOUT'] != null) ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", $row['TOTALTIME']): null ;?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <form action="QR_Log_insert.php" method="post" class="form-horizontal" name="text">
                                <input type="hidden" name="text" id="text" readonny="" placeholder="scan qrcode" class="form-control">
                            </form>
                        </div> 

                    </div>

                    <div class="container-fluid p-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
        
        <!-- FOR CAMERA -->
        <script>
             let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
                Instascan.Camera.getCameras().then(function(cameras)
                {
                    if(cameras.length > 0){
                        scanner.start(cameras[0]);
                    } else {
                        alert('No cameras found');
                    }
                }).catch(function(e){
                    console.error(e);
                });

                scanner.addListener('scan', function(c){
                    document.getElementById('text').value=c;
                    document.forms['text'].submit();
                });
        </script>

    </body>
</html>
