<?php
// Start the session if it hasn't been started yet
if (!isset($_SESSION)) {
    session_start();
}

// Define constants
define('TITLE', 'Student Profile');
define('PAGE', 'profile');
include('./stuInclude/header.php');
include_once('../dbConnection.php');

// Check if the user is logged in
if (isset($_SESSION['is_login'])) {
    $stuEmail = $_SESSION['stuLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

// Fetch student details using prepared statements to prevent SQL injection
$sql = $conn->prepare("SELECT * FROM student WHERE stu_email = ?");
$sql->bind_param("s", $stuEmail);
$sql->execute();
$result = $sql->get_result();

// If the student exists, fetch their details
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId = $row["stu_id"];
    $stuFname = $row["stu_first_name"];
    $stuLname = $row["stu_last_name"];
    $stuUser = $row["stu_username"];
    $stuDob = $row["stu_dob"];
    $stuSex = $row["stu_sex"];
    $stuProgram = $row["stu_program"];
    $stuImg = $row["stu_img"];
} else {
    echo "<div class='alert alert-danger'>Student record not found!</div>";
    exit;
}

// Handle form submission for updating student details
if (isset($_REQUEST['updateStuNameBtn'])) {
    if (
        empty($_POST["stuFname"]) || empty($_POST["stuLname"]) ||
        empty($_POST["stuUser"]) || empty($_POST["stuDob"]) ||
        empty($_POST["stuSex"]) || empty($_POST["stuProgram"])
    ) {
        $passmsg = '<div class="alert alert-warning" role="alert">Fill All Fields</div>';
    } else {
        // Collect updated data from the form
        $stuFname = $_POST["stuFname"];
        $stuLname = $_POST["stuLname"];
        $stuUser = $_POST["stuUser"];
        $stuDob = $_POST["stuDob"];
        $stuSex = $_POST["stuSex"];
        $stuProgram = $_POST["stuProgram"];

        // Handle file upload for student image
        if (!empty($_FILES['stuImg']['name'])) {
            $stuImg = $_FILES['stuImg']['name'];
            $stuImgTemp = $_FILES['stuImg']['tmp_name'];
            $imgFolder = '../image/stu/' . $stuImg;

            // Move the uploaded file to the destination folder
            if (!move_uploaded_file($stuImgTemp, $imgFolder)) {
                $passmsg = '<div class="alert alert-danger" role="alert">Failed to upload image</div>';
                $stuImg = $row["stu_img"]; // Retain the old image
            }
        }

        // Update student details using a prepared statement
        $updateSql = $conn->prepare("UPDATE student SET stu_first_name = ?, stu_last_name = ?, stu_username = ?, stu_dob = ?, stu_sex = ?, stu_program = ?, stu_img = ? WHERE stu_email = ?");
        $updateSql->bind_param("ssssssss", $stuFname, $stuLname, $stuUser, $stuDob, $stuSex, $stuProgram, $stuImg, $stuEmail);

        if ($updateSql->execute()) {
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Profile updated successfully.",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
            </script>';
            $passmsg = '<div class="alert alert-success" role="alert">Updated Successfully</div>';
        } else {
            $passmsg = '<div class="alert alert-danger" role="alert">Unable to Update</div>';
        }
    }
}
?>

<div class="col-sm-6 mt-5">
    <form class="mx-5" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="stuId">Student ID</label>
            <input type="text" class="form-control" id="stuId" name="stuId" value="<?php echo htmlspecialchars($stuId); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="stuEmail">Email</label>
            <input type="email" class="form-control" id="stuEmail" value="<?php echo htmlspecialchars($stuEmail); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="stuFname">First Name</label>
            <input type="text" class="form-control" id="stuFname" name="stuFname" value="<?php echo htmlspecialchars($stuFname); ?>">
        </div>
        <div class="form-group">
            <label for="stuLname">Last Name</label>
            <input type="text" class="form-control" id="stuLname" name="stuLname" value="<?php echo htmlspecialchars($stuLname); ?>">
        </div>
        <div class="form-group">
            <label for="stuUser">Username</label>
            <input type="text" class="form-control" id="stuUser" name="stuUser" value="<?php echo htmlspecialchars($stuUser); ?>">
        </div>
        <div class="form-group">
            <label for="stuDob">Date of Birth</label>
            <input type="date" class="form-control" id="stuDob" name="stuDob" value="<?php echo htmlspecialchars($stuDob); ?>">
        </div>
        <div class="form-outline mb-4">
            <label for="stuSex">Sex</label>
            <select class="form-control" id="stuSex" name="stuSex">
                <option value="Male" <?php if ($stuSex == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($stuSex == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($stuSex == 'Other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="stuProgram">Program</label>
            <input type="text" class="form-control" id="stuProgram" name="stuProgram" value="<?php echo htmlspecialchars($stuProgram); ?>">
        </div>
        <div class="form-group">
            <label for="stuImg">Upload Image</label>
            <input type="file" class="form-control-file" id="stuImg" name="stuImg">
            <?php if (!empty($stuImg)) : ?>
                <img src="<?php echo htmlspecialchars($stuImg); ?>" alt="Student Image" style="width: 100px; height: 100px; margin-top: 10px;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary" name="updateStuNameBtn">Update</button>
        <?php if (isset($passmsg)) echo $passmsg; ?>
    </form>
</div>

<?php include('./stuInclude/footer.php'); ?>
