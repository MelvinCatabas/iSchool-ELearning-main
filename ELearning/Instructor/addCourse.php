<?php
if (!isset($_SESSION)) { 
  session_start(); 
}
define('TITLE', 'Add Course');
define('PAGE', 'add course');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

$currentDate = date('Y-m-d'); 

if (isset($_SESSION['is_instructor_login'])) {
  $instructorEmail = $_SESSION['instructorLogEmail'];
  

  $sql = "SELECT instructor_id FROM instructor WHERE instructor_email = '$instructorEmail'";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $instructor_id = $row['instructor_id'];
  } else {
    echo "<script>alert('Instructor not found.');</script>";
    echo "<script> location.href='../index.php'; </script>";
  }
} else {
  echo "<script> location.href='../index.php'; </script>";
}

if (isset($_REQUEST['courseSubmitBtn'])) {
  if (empty($_REQUEST['course_name']) || empty($_REQUEST['course_desc'])) {
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    // Assigning User Values to Variables
    $course_name = $_REQUEST['course_name'];
    $course_desc = $_REQUEST['course_desc'];
    $course_date = !empty($_REQUEST['course_date']) ? $_REQUEST['course_date'] : $currentDate; 
    $course_image = $_FILES['course_img']['name']; 
    $course_image_temp = $_FILES['course_img']['tmp_name'];
    $img_folder = '../image/courseimg/' . $course_image; 
    move_uploaded_file($course_image_temp, $img_folder);

    // Insert Query with the Instructor ID as a Foreign Key
    $sql = "INSERT INTO course (course_name, course_desc, course_img, course_date, instructor_id) 
            VALUES ('$course_name', '$course_desc', '$img_folder', '$course_date', '$instructor_id')";
    if ($conn->query($sql) === TRUE) {
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Course Added Successfully </div>';
    } else {
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Course </div>';
    }
  }
}
?>

<div class="col-sm-6 mt-5 mx-3 jumbotron">
  <h3 class="text-center">Add New Course</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="course_name">Course Name</label>
      <input type="text" class="form-control" id="course_name" name="course_name">
    </div>
    <div class="form-group">
      <label for="course_desc">Course Description</label>
      <textarea class="form-control" id="course_desc" name="course_desc" rows="2"></textarea>
    </div>
    <div class="form-group">
      <label for="course_date">Course Date</label>
      <input type="date" class="form-control" id="course_date" name="course_date" value="<?php echo $currentDate; ?>">
    </div>
    <div class="form-group">
      <label for="course_img">Course Image</label>
      <input type="file" class="form-control-file" id="course_img" name="course_img">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="courseSubmitBtn" name="courseSubmitBtn">Submit</button>
      <a href="courses.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if (isset($msg)) { echo $msg; } ?>
  </form>
</div>

<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }
</script>

<?php
include('./instructorInclude/footer.php');
?>
