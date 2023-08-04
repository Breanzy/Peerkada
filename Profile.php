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
                    <div class = "container-fluid px-3">
                        <div class= "row">
                            <div class="col-md-4 p-2">
                                <img src="testt.jpg" class="img-fluid rounded-circle mx-auto d-block" alt="Image" style="height: 50%;">
                            </div>
     
                            <div class="col-md-6">
              
                                <h3>BREANZY</h3>
                                <h6 class="theme-color lead">Senior SPF</h6>
                                <br>
                                <div class="row about-list">
                                    <div class="col-md-6">
                                        <div class="media">
                                            <label>Birthday</label>
                                            <p>4th april 1998</p>
                                        </div>
                                        <div class="media">
                                            <label>Age</label>
                                            <p>22 Yr</p>
                                        </div>
                                        <div class="media">
                                            <label>Residence</label>
                                            <p>Canada</p>
                                        </div>
                                        <div class="media">
                                            <label>Address</label>
                                            <p>California, USA</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="media">
                                            <label>E-mail</label>
                                            <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="462f2820290622292b272f286825292b">[email&#160;protected]</a></p>
                                        </div>
                                        <div class="media">
                                            <label>Phone</label>
                                            <p>820-885-3321</p>
                                        </div>
                                        <div class="media">
                                            <label>Skype</label>
                                            <p>skype.0404</p>
                                        </div>
                                        <div class="media">
                                            <label>Freelance</label>
                                            <p>Available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3 shadow rounded-3 p-3 m-4">
                                <div class="count-data text-center hover-overlay">
                                    <h6 class="count h2" data-to="500" data-speed="500">500</h6>
                                    <p class="m-0px font-w-600">Happy Clients</p>
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%"
                                        aria-valuemin="0" aria-valuemax="100">25%</div>
                                    </div>

                                    <div class="progress mb-2">
											<div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%"
											 aria-valuemin="0" aria-valuemax="100">75%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 shadow rounded-3 p-3 m-4">
                                <div class="count-data text-center">
                                    <h6 class="count h2" data-to="150" data-speed="150">150</h6>
                                    <p class="m-0px font-w-600">Project Completed</p>
                                </div>
                            </div>
                            <div class="col-md-3 shadow rounded-3 p-3 m-4">
                                <div class="count-data text-center">
                                    <h6 class="count h2" data-to="850" data-speed="850">850</h6>
                                    <p class="m-0px font-w-600">Photo Capture</p>
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
                                        $server = "localhost";
                                        $username="root";
                                        $password="";
                                        $dbname="qrcode";
                                        
                                        date_default_timezone_set("Asia/Singapore");
                                        $DATE = date('d-m-Y');

                                        $conn = new mysqli($server, $username, $password, $dbname);
                                        if($conn->connect_error){
                                            die("Connection failed" .$conn->connect_error);
                                        }
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
