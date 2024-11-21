<?php
if (!isset($_SESSION)) { 
    session_start(); 
}
define('TITLE', 'Profile');
define('PAGE', 'profile');
include('./instructorInclude/header.php'); 
include_once('../dbConnection.php');

// Check if instructor is logged in
if (isset($_SESSION['is_instructor_login'])) {
    $instructorEmail = $_SESSION['instructorLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

// Fetch instructor details
$sql = "SELECT * FROM instructor WHERE instructor_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $instructorEmail);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $inst_id = $row['instructor_id'];
    $inst_fname = $row['instructor_fname'];
    $inst_lname = $row['instructor_lname'];
    $inst_dob = $row['instructor_dob'];
    $inst_sex = $row['instructor_sex'];
    $inst_email = $row['instructor_email'];
    $inst_img = $row['instructor_img'];
}

// Update instructor details
if (isset($_POST['requpdate'])) {
    if (empty($_POST['instructor_fname']) || empty($_POST['instructor_lname']) || empty($_POST['instructor_dob']) || empty($_POST['instructor_sex']) || empty($_POST['instructor_email'])) {
        $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
    } else {
        $instructor_fname = $_POST['instructor_fname'];
        $instructor_lname = $_POST['instructor_lname'];
        $instructor_dob = $_POST['instructor_dob'];
        $instructor_sex = $_POST['instructor_sex'];
        $instructor_email = $_POST['instructor_email'];

        // Handle image upload
        if (!empty($_FILES['instructor_img']['name'])) {
            $inst_image_temp = $_FILES['instructor_img']['tmp_name'];
            $inst_image_name = uniqid() . "_" . $_FILES['instructor_img']['name'];
            $img_folder = '../image/instimg/' . $inst_image_name;
            move_uploaded_file($inst_image_temp, $img_folder);
        } else {
            $img_folder = $inst_img; // Keep existing image if not updated
        }

        $sql = "UPDATE instructor SET instructor_fname = ?, instructor_lname = ?, instructor_dob = ?, instructor_sex = ?, instructor_email = ?, instructor_img = ? WHERE instructor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $instructor_fname, $instructor_lname, $instructor_dob, $instructor_sex, $instructor_email, $img_folder, $inst_id);

        if ($stmt->execute()) {

          echo '<script>
        Swal.fire({
            title: "Success!",
            text: "Update Successfully .",
            icon: "success",
            timer: 1500,
            showConfirmButton: false
        }).then(function() {
            Swal.close();
        });
    </script>';

    
    $_SESSION['alert_shown'] = true;
    
            $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
        } else {
            $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
        }
    }
}
?> 

<div class="col-sm-6 mt-5">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="instructor_id">Instructor ID</label>
            <input type="text" class="form-control" id="instructor_id" name="instructor_id" value="<?php echo $inst_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="instructor_fname">Instructor First Name</label>
            <input type="text" class="form-control" id="instructor_fname" name="instructor_fname" value="<?php echo $inst_fname; ?>">
        </div>
        <div class="form-group">
            <label for="instructor_lname">Instructor Last Name</label>
            <input type="text" class="form-control" id="instructor_lname" name="instructor_lname" value="<?php echo $inst_lname; ?>">
        </div>
        <div class="form-group">
            <label for="instructor_dob">Instructor DOB</label>
            <input type="date" class="form-control" id="instructor_dob" name="instructor_dob" value="<?php echo $inst_dob; ?>">
        </div>
        <div class="form-group">
            <label for="instructor_sex">Instructor Sex</label>
            <input type="text" class="form-control" id="instructor_sex" name="instructor_sex" value="<?php echo $inst_sex; ?>">
        </div>
        <div class="form-group">
            <label for="instructor_email">Instructor Email</label>
            <input type="text" class="form-control" id="instructor_email" name="instructor_email" value="<?php echo $inst_email; ?>">
        </div>
        <div class="form-group">
            <label for="instructor_img">Instructor Image</label>
            <img src="<?php echo $inst_img; ?>" alt="instructorimage" class="img-thumbnail mb-2">     
            <input type="file" class="form-control-file" id="instructor_img" name="instructor_img">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
            <a href="instructor.php" class="btn btn-secondary">Close</a>
        </div>
        <?php if (isset($passmsg)) { echo $passmsg; } ?>
    </form>
</div>

<?php
include('./instructorInclude/footer.php'); 
?>
