<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="../pages/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <?php if (isset($_SESSION['isAdmin'])) { ?>
                    <a class="nav-link" href="../pages/AdminDash.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                        Admin Dashboard
                    </a>
                <?php } ?>


                <?php if (isset($_SESSION['name'])) { ?>
                    <div class="sb-sidenav-menu-heading">User</div>
                    <a class="nav-link" href="../pages/Profile.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                        Profile
                    </a>
                <?php } ?>

                <a class="nav-link" href="register.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                    Create New Profile
                </a>

            </div>
        </div>

        <!-- New footer section - visible only on smaller screens (d-md-none) -->
        <div class="sb-sidenav-footer d-md-none">
            <div class="small">Logged in as:</div>
            <div class="d-flex align-items-center justify-content-between mt-2">
                <div class="fw-bold"><?php echo (isset($_SESSION["name"]) ? $_SESSION["name"] : "Guest"); ?></div>
                <a class="btn btn-outline-light btn-sm py-1" href="../controllers/Logout.php">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
            </div>
        </div>
    </nav>
</div>