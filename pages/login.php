<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Login</title>
</head>


<body class="bg-dark d-flex flex-column min-vh-100">

    <?php unset($_SESSION['name']); ?>
    <div class="container h-100 flex-fill d-flex align-items-center justify-content-center">
        <div class="row w-100 d-flex justify-content-between align-items-center gap-4">
            <div class="col-lg-6 mx-auto d-flex justify-content-around gap-3 align-items-center">
                <img src="../assets/icon.ico" class="img-fluid">
                <div class="p-4">
                    <p class="p-0 m-0 fw-bolder fs-1 text-info">Peerkada</p>
                    <p class="p0 m-0 fs-5 text-light">Your Peer Network, Organized</p>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Login</h5>
                        <form action="../controllers/Login_Check.php" method="post" class="form-horizontal">
                            <div class="form-group mb-3">
                                <label class="label" for="ID_Number">ID Number</label>
                                <input type="text" name="ID_Number" class="form-control" placeholder="Ex. 20191387" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="label" for="User_Password">Password</label>
                                <input type="password" name="User_Password" class="form-control" placeholder="Password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between mt-3">
                            <p class="text-center my-auto">Not a member? <a data-toggle="tab" href="register.php">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('../components/Footer.php'); ?>
</body>

</html>