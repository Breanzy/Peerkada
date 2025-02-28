<?php
// Check for profile picture in various formats
$school_id = $SchoolID; // Using the ID from the session
$profile_pic_found = false;
$profile_pic_path = "../assets/ProfilePictures/default.jpg"; // Default image

// Check for possible file extensions
$extensions = ['jpg', 'jpeg', 'png', 'gif'];
foreach ($extensions as $ext) {
    $test_path = "../assets/ProfilePictures/" . $school_id . "." . $ext;
    if (file_exists($test_path)) {
        $profile_pic_path = $test_path;
        $profile_pic_found = true;
        break;
    }
}
?>


<div class="row">
    <div class="col-xl-4 p-10 d-flex justify-content-center align-items-center">
        <div class="" style="height: 250px; width: 250px;">

            <img src="<?php echo $profile_pic_path; ?>" alt="Profile Picture" class="img-fluid rounded-circle border border-primary" style="width: 200px; height: 200px; object-fit: cover;">
        </div>
    </div>
    I'LL BE AT SCHOOL TOMORROW SO I PROMISE YOU FOR SURE I WILL FINISH THIS 

    <div class="col-xl-8 col-md-12 center-align text-lg-start text-center">
        <div class="fw-bold fs-1"><?php echo $Name; ?></div>
        <h6 class="theme-color lead"><?php echo $Title; ?></h6>
        <br>
        <div class="row about-list fs-3">
            <div class="col-sm-6 col-xs-12">
                <div class="media">
                    <label class="fw-bold">Birthday</label>
                    <p><?php echo $Birth; ?></p>
                </div>
                <div class="media">
                    <label class="fw-bold">Address</label>
                    <p><?php echo $Address; ?></p>
                </div>

                <div class="media">
                    <label class="fw-bold">E-mail</label>
                    <p><?php echo $Email; ?></p>
                </div>
                <div class="media">
                    <label class="fw-bold">Phone</label>
                    <p><?php echo $Number; ?></p>

                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="media">
                    <label class="fw-bold">School ID</label>
                    <p><?php echo $SchoolID; ?></p>
                </div>
                <div class="media">
                    <label class="fw-bold">College</label>
                    <p><?php echo $College; ?></p>
                </div>
                <div class="media">
                    <label class="fw-bold">Course</label>
                    <p><?php echo $Course; ?></p>
                </div>
                <div class="media">
                    <label class="fw-bold">School Year</label>
                    <p><?php echo $SchoolYr; ?></p>
                </div>
            </div>

        </div>
    </div>
</div>