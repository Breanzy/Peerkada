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

    </head>

    <body class="sb-nav-fixed">

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand text-center" href="index.php">PEERKADA</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
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
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
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
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="register.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Create New Profile
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
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
                                <table class="table table-hover table-bordered table-striped rounded-3 overflow-hidden">
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

                                        $sql ="SELECT * FROM table_attendance WHERE LOGDATE = '$DATE' ORDER BY ATTENDANCE_ID DESC limit 6";
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
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
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


        <script src="js/scripts.js"></script>


        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript"></script>                    
    </body>
</html>
