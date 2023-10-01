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
        
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark justify-content-between">
            <!-- Navbar Brand-->

            <div class="col-xl-6 col-6">
                <div class="row justify-content-start">
                    <div class="col-auto"><a class="m-0 fw-bold fs-3 text-start m-3 navbar-brand" href="index.php">PEERKADA</a></div>
                    <!-- Sidebar Toggle-->
                    <div class="col-auto text-start"><button class="btn btn-link btn-sm" id="sidebarToggle" href="#!"><i class="fas fa-bars">SUP</i></button></div>              
                </div>
            </div>

            <div class="col-xl-3 col-6">
                <div class="row justify-content-end">
                    <div class="col-auto text-white text-end fw-lighter">Logged in as: <?php echo $_SESSION["name"];?> </div>
                    <div class="col-auto"><a class="text-white text-end fw-bold m-3" href="login.php">OUT</a></div>
                </div>

                <!-- Navbar-->
                <!-- <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 end-0 float-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">Settings</a></li>
                            <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Logout</a></li>
                        </ul>
                    </li>
                </ul> -->
            </div>

        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <!-- NAVIGATION BUTTONS -->
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <!-- <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a> -->
                            <!-- <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> -->
                            <!-- <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div> -->
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="Profile.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Profile
                            </a>
                            <a class="nav-link" href="register.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Create New Profile
                            </a>
                        </div>
                    </div>
                    <!-- <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div> -->
                </nav>
            </div>

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

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Hi hehehehe</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
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
