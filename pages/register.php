<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/Header.php'; ?>
    <title>Peerkada | Register</title>
</head>

<body class="sb-nav-fixed" style="background: linear-gradient(0deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.3)), url(../assets/backgroundd.jpg); background-repeat: no-reapeat; background-attachment: fixed; background-size: cover;">
    <!-- Notifications -->
    <?php include('../components/TopNav.php'); ?>
    <div id="layoutSidenav">
        <?php include('../components/SideNav.php'); ?>

        <div id="layoutSidenav_content">
            <div id="layoutAuthentication">
                <div id="layoutAuthentication_content" class="d-flex flex-column justify-content-start">
                    <main>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 pt-4">
                                    <div class="card rounded-3">

                                        <div class="card-header">
                                            <strong>PROFILE</strong> Creation Form
                                        </div>

                                        <div class="card-body card-block text-left">
                                            <form action="../controllers/Register_Log_Insert.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                <div class="row form-group my-2">
                                                    <div class="col-md-7">
                                                        <input type="text" name="Name" placeholder="Last Name, First Name" class="form-control" required>
                                                        <small class="help-block form-text">Please enter your Name</small>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="number" name="SchoolID" placeholder="20191387" class="form-control" required>
                                                        <small class="help-block form-text">Enter ID Number</small>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <select name="Title" class="form-control" required>
                                                            <option value="" disabled selected>Title</option>
                                                            <option value="Assistant">SPF Assistant</option>
                                                            <option value="Junior">SPF Junior</option>
                                                            <option value="Senior">SPF Senior</option>
                                                            <option value="LAV">LAV Associate</option>
                                                        </select>
                                                        <small class="help-block form-text">Select Org Title</small>
                                                    </div>
                                                </div>

                                                <div class="row form-group my-2">
                                                    <div class="col-md-4">
                                                        <select name="College" class="form-control" required>
                                                            <option value="" disabled selected>Select College</option>
                                                            <option value="COE">COE</option>
                                                            <option value="CHS">CHS</option>
                                                            <option value="CEBA">CEBA</option>
                                                            <option value="CCS">CCS</option>
                                                            <option value="CED">CED</option>
                                                            <option value="CSM">CSM</option>
                                                            <option value="CASS">CASS</option>
                                                        </select>
                                                        <small class="help-block form-text">Select College</small>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <select name="SchoolYr" class="form-control" required>
                                                            <option value="" disabled selected>Year Level</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">Other</option>
                                                        </select>
                                                        <small class="help-block form-text">Select Year Level</small>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <input type="text" name="Course" placeholder="BS (Course)" class="form-control" required>
                                                        <small class="help-block form-text">Enter Course</small>
                                                    </div>
                                                </div>

                                                <div class="row form-group my-2">
                                                    <div class="col-md-6">
                                                        <input type="email" name="Email" placeholder="Enter Email" class="form-control" required>
                                                        <small class="help-block form-text">Please enter your email address</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="tel" name="Number" placeholder="Enter Phone #" class="form-control" required>
                                                        <small class="help-block form-text">Please enter your phone number</small>
                                                    </div>

                                                </div>


                                                <div class="row form-group my-2">
                                                    <div class="col-md-7">
                                                        <input type="text" name="Address" placeholder="Home Address" class="form-control" required>
                                                        <small class="help-block form-text">Please enter your current home address</small>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="date" name="Birth" placeholder="Date of Birth" class="form-control" required>
                                                        <small class="help-block form-text">Enter Date of Birth</small>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <select name="Sex" class="form-control" required>
                                                            <option value="" disabled selected>Sex</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <small class="help-block form-text">Select Sex</small>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <input type="password" name="Password" class="form-control" required>
                                                        <small class="help-block form-text">Please Input Your Password</small>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="file" name="profile_picture" id="profile_picture" class="form-control-file">
                                                        <small class="help-block form-text">Please Select your Profile Picture</small>
                                                    </div>
                                                </div>

                                                <div class="card-footer rounded-3">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-dot-circle-o"></i> Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

            </div>
        </div>
</body>

</html>