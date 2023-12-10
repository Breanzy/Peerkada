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