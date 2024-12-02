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
            <div class="col-auto text-white text-end fw-lighter">Logged in as: <?php echo (isset($_SESSION["name"]) ? $_SESSION["name"] : "Guest"); ?> </div>
            <div class="col-auto"><a class="text-white text-end fw-bold m-3" href="../controllers/logout.php">Log Out</a></div>
        </div>
    </div>
</nav>