<div class="row">
    <div class="col-xl-4 p-10 d-flex justify-content-center align-items-center">
        <div class="position-relative" style="height: 250px; width: 250px;">
            <?php
            // Check if user has a profile picture
            $profilePicPath = "../assets/ProfilePictures/" . $SchoolID . ".jpg";
            $defaultPicPath = "../assets/ProfilePictures/default.jpg";

            // If file doesn't exist with .jpg, try other extensions
            if (!file_exists($profilePicPath)) {
                $profilePicPath = "../assets/ProfilePictures/" . $SchoolID . ".jpeg";
                if (!file_exists($profilePicPath)) {
                    $profilePicPath = "../assets/ProfilePictures/" . $SchoolID . ".png";
                    if (!file_exists($profilePicPath)) {
                        $profilePicPath = "../assets/ProfilePictures/" . $SchoolID . ".gif";
                        if (!file_exists($profilePicPath)) {
                            // If no profile pic found with any extension, use default
                            $profilePicPath = $defaultPicPath;
                        }
                    }
                }
            }

            // Add a timestamp parameter to prevent browser caching
            $profilePicPath = $profilePicPath . "?t=" . time();
            ?>

            <!-- Profile image with Bootstrap classes for borders and interactive elements -->
            <div class="border border-primary border-3 rounded-circle p-1 h-100 w-100">
                <img src="<?php echo $profilePicPath; ?>"
                    class="h-100 w-100 rounded-circle"
                    style="object-fit: cover;"
                    alt="Profile Image"
                    id="profilePicture"
                    data-bs-toggle="modal"
                    data-bs-target="#changeProfilePicModal">
            </div>
        </div>
    </div>

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

        </div>
    </div>
</div>