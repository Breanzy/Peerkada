<div class="row g-4 py-4">
    <!-- Profile Image Section - Left side -->
    <div class="col-lg-12 col-xl d-flex justify-content-center align-items-center">
        <div class="position-relative" style="height: 350px; width: 350px;">
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

            <!-- Profile image with enhanced styling -->
            <div class="shadow-lg border-4 border-primary rounded-circle p-1 h-100 w-100 position-relative overflow-hidden"
                style="transition: all 0.3s ease;">
                <img src="<?php echo $profilePicPath; ?>"
                    class="h-100 w-100 rounded-circle"
                    style="object-fit: cover;"
                    alt="Profile Image"
                    id="profilePicture"
                    data-bs-toggle="modal"
                    data-bs-target="#changeProfilePicModal">
                <div class="position-absolute bottom-0 start-0 end-0 bg-primary bg-opacity-75 text-white text-center py-1"
                    style="cursor: pointer; font-size: 12px;">
                    Change Photo
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details Section - Right side -->
    <div class="col">
        <div class="card shadow-lg border-0 h-100">
            <div class="card-body">
                <!-- Header with name and title -->
                <div class="text-center mb-4 py-2 border-bottom">
                    <h2 class="display-6 fw-bold mb-1"><?php echo $Name; ?></h2>
                    <p class="text-primary fs-5 fst-italic"><?php echo $Title; ?></p>
                </div>

                <!-- Information items in a clean grid -->
                <div class="row g-3">
                    <!-- Personal Information Section -->
                    <div class="col-12 mb-2">
                        <h5 class="text-primary border-bottom pb-2">Personal Information</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-calendar-date fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">Birthday</div>
                                <div><?php echo $Birth; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-envelope fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">E-mail</div>
                                <div class="text-break"><?php echo $Email; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-telephone fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">Phone</div>
                                <div><?php echo $Number; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-geo-alt fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">Address</div>
                                <div class="text-break"><?php echo $Address; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information Section -->
                    <div class="col-12 mt-2 mb-2">
                        <h5 class="text-primary border-bottom pb-2">Academic Information</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-badge fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">School ID</div>
                                <div><?php echo $SchoolID; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-building fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">College</div>
                                <div class="text-break"><?php echo $College; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-book fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">Course</div>
                                <div class="text-break"><?php echo $Course; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-calendar3 fs-4 text-primary me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-secondary small">School Year</div>
                                <div><?php echo $SchoolYr; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for changing profile picture (unchanged) -->
<div class="modal fade" id="changeProfilePicModal" tabindex="-1" aria-labelledby="changeProfilePicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeProfilePicModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controllers/UpdateProfilePicture.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Select New Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/gif" required>
                        <div class="form-text">Accepted formats: JPG, JPEG, PNG, GIF</div>
                    </div>
                    <input type="hidden" name="school_id" value="<?php echo $SchoolID; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload New Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview selected image script (unchanged) -->
<script>
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePicture').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>