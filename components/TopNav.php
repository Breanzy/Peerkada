<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark p-2">
    <!-- Navbar Brand-->
    <div class="d-flex align-items-center">
        <div class="">
            <img src="../assets/logowhite.png" alt="logo" class="" style="max-height: 75px;"> <!-- Use img-fluid for responsiveness -->
        </div>
        <a class="m-0 fw-bold fs-3 text-white navbar-brand text-center" href="index.php">PEERKADA</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm ms-3" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </div>

    <div class="ms-auto d-flex align-items-center">
        <div class="text-white fw-lighter">Logged in as: <?php echo (isset($_SESSION["name"]) ? $_SESSION["name"] : "Guest"); ?></div>
        <a class="text-white fw-bold ms-3" href="../controllers/logout.php">Log Out</a>
    </div>
</nav>

<!-- Toggle the side navigation -->
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        const sidebarToggle = document.body.querySelector("#sidebarToggle");
        if (sidebarToggle) {
            if (localStorage.getItem("sb|sidebar-toggle") === "true") {
                document.body.classList.toggle("sb-sidenav-toggled");
            }
            sidebarToggle.addEventListener("click", (event) => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
                localStorage.setItem(
                    "sb|sidebar-toggle",
                    document.body.classList.contains("sb-sidenav-toggled")
                );
            });
        }
    });
</script>