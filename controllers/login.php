<?php session_start(); ?>
<!doctype html>
<html lang="en">
      <head>
        <title>Login | PEERKADA</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="icon.ico">

        
        <link rel="stylesheet" href="css/styles.css">


        <link rel="stylesheet" href="css/customStyle.css">


    </head>


    <body style="background: linear-gradient(0deg, rgba(20, 20, 20, 0.9), rgba(20, 20, 20, 0.3)), url(https://thumbs.gfycat.com/AnotherDistantBirdofparadise-max-1mb.gif); background-repeat: no-reapeat; background-attachment: fixed; background-size: cover;">
        
        <?php unset($_SESSION['name']); ?>

        <div class="container-fluid p-5">
            <?php
            if (isset($_SESSION['error'])) {
                echo "
					<div class='position-absolute top-0 end-0 alert alert-danger alert-dismissible fadee' style='background:red;color:#fff'>
						<h4><i class='icon fa fa-warning fadee'></i> Error!</h4>
						" . $_SESSION['error'] . "
					</div>
					";
                unset($_SESSION['error']);

            }
            if (isset($_SESSION['success'])) {
                echo "
					<div class='position-absolute top-0 end-0 alert alert-success alert-dismissible fadee' style='background:green;color:#fff'>
						<h4><i class='icon fa fa-check'></i> Success!</h4>
						" . $_SESSION['success'] . "
					</div>
					";
                unset($_SESSION['success']);
            }
            ?>




            <div class="row">
                <div class="col-xl-6 col-12 px-0 text-center">
                    <img src="icon.ico" class="img-fluid p-3">
                </div>

                <div class="col-xl-4 col-8">
                    <div class="login-wrap">
                        
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Sign In</h3>
                            </div>
                        </div>

                        <form action="Login_Check.php" method="post" class="form-horizontal">
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
                        <p class="text-center">Not a member? <a data-toggle="tab" href="register.php">Sign Up</a></p>
                        <p class="text-center"><a data-toggle="tab" href="register.php">GUEST MODE</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

