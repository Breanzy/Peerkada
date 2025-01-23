<?php
// Include the PDO configuration
require '../config.php';

$id = $_GET['id'] ?? null;
$user = null;

if ($id) {
    try {
        // Fetch the user details based on the ID
        $query = "SELECT * FROM members_profile WHERE ID = :id"; // Adjust table name as needed
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $name = $_POST['name'];
    $title = $_POST['title'];
    $college = $_POST['college'];
    $schoolYear = $_POST['school_year'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $birthDate = $_POST['birth_date'];
    $sex = $_POST['sex'];

    try {
        // Update the user details
        $updateQuery = "UPDATE members_profile SET 
            NAME = :name, 
            TITLE = :title, 
            COLLEGE = :college, 
            SCHOOL_YR = :school_year, 
            COURSE = :course, 
            EMAIL_ADD = :email, 
            PHONE_NUM = :phone, 
            ADDRESS = :address, 
            BIRTH = :birth_date, 
            SEX = :sex 
            WHERE ID = :id";

        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':college', $college);
        $stmt->bindParam(':school_year', $schoolYear);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':birth_date', $birthDate);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the admin dashboard or show a success message
        header("Location: admin_dashboard.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit User</h1>
        <?php if ($user): ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['NAME']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($user['TITLE']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="college" class="form-label">College</label>
                    <input type="text" class="form-control" id="college" name="college" value="<?php echo htmlspecialchars($user['COLLEGE']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="school_year" class="form-label">School Year</label>
                    <input type="text" class="form-control" id="school_year" name="school_year" value="<?php echo htmlspecialchars($user['SCHOOL_YR']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="course" class="form-label">Course</label>
                    <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($user['COURSE']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['EMAIL_ADD']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['PHONE_NUM']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['ADDRESS']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Birth Date</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($user['BIRTH']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sex" class="form-label">Sex</label>
                    <select class="form-select" id="sex" name="sex" required>
                        <option value="Male" <?php echo ($user['SEX'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($user['SEX'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($user['SEX'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</body>

</html>