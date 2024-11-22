<?php
if (!isset($_SESSION)) { 
    session_start(); 
}

define('TITLE', 'Add Lesson');
define('PAGE', 'add lesson');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

if (isset($_SESSION['is_instructor_login'])) {
    $instructorEmail = $_SESSION['instructorLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}

if (isset($_REQUEST['activitySubmitBtn'])) {
    // Check if all required fields are filled
    if (empty($_REQUEST['activity_title']) || empty($_REQUEST['course_id']) || empty($_REQUEST['activity_link'])) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
    } else {
        // Sanitize and assign user input to variables
        $activity_title = $_REQUEST['activity_title'];
        $activity_link = $_REQUEST['activity_link'];

        // Ensure course_id is passed either from the session or via the URL
        $course_id = $_REQUEST['course_id'];  // Get course_id from form input

        // Insert the activity into the database
        $sql = "INSERT INTO activity (activity_title, activity_link, course_id) VALUES ('$activity_title', '$activity_link', '$course_id')";
        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Lesson Added Successfully </div>';
        } else {
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Lesson </div>';
        }
    }
}
?>

<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Activity</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="course_id">Course ID</label>
      <!-- Fix for course_id: check if course_id is set in session or in GET request -->
      <input type="text" class="form-control" id="course_id" name="course_id" value="<?php if (isset($_GET['course_id'])) { echo $_GET['course_id']; } elseif (isset($_SESSION['course_id'])) { echo $_SESSION['course_id']; } ?>" readonly>
    </div>
    <div class="form-group">
      <label for="activity_title">Activity Title</label>
      <input type="text" class="form-control" id="activity_title" name="activity_title">
    </div>
    <div class="form-group">
      <label for="activity_link">Activity File Link</label>
      <input type="text" class="form-control" id="activity_link" name="activity_link">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="activitySubmitBtn" name="activitySubmitBtn">Submit</button>
      <a href="activity.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if (isset($msg)) { echo $msg; } ?>
  </form>
</div>

<?php
include('./instructorInclude/footer.php');
?>
