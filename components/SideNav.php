<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="../pages/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Dashboard
                </a>

                <?php if (isset($_SESSION['name']) && $_SESSION['name'] == 'ADMIN') { ?>
                    <a class="nav-link" href="../pages/AdminDash.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Admin Dashboard
                    </a>
                <?php } ?>


                <?php if (isset($_SESSION['name'])) { ?>
                    <div class="sb-sidenav-menu-heading">User</div>
                    <a class="nav-link" href="../pages/Profile.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Profile
                    </a>
                <?php } ?>

                <a class="nav-link" href="register.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Create New Profile
                </a>

            </div>
        </div>
    </nav>
</div>