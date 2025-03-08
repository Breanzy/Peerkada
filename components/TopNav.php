<nav class="sb-topnav navbar navbar-dark bg-dark p-2">
    <!-- Container with position relative to allow absolute positioning -->
    <div class="container-fluid position-relative">
        <!-- Left side: Logo (hidden on xs screens) -->
        <div class="">
            <img src="../assets/logowhite.png" alt="logo" style="height: 3rem; width: auto;">
        </div>
        <a class="fw-bold text-white navbar-brand ms-2" href="index.php">PEERKADA</a>

        <!-- Right side: Spacer, User info, logout, and toggle -->
        <div class="ms-auto d-flex align-items-center">
            <!-- User info - hidden on small screens -->
            <span class="text-white fw-lighter me-2 d-none d-md-inline">
                Logged in as: <?php echo (isset($_SESSION["name"]) ? $_SESSION["name"] : "Guest"); ?>
            </span>

            <!-- Logout button - hidden on small screens -->
            <a class="btn btn-outline-light btn-sm me-2 d-none d-md-inline-flex" href="../controllers/Logout.php">
                <i class="fas fa-sign-out-alt me-1"></i>Log Out
            </a>

            <!-- Sidebar toggle -->
            <button class="btn btn-link btn-sm p-1" id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button>
        </div>
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