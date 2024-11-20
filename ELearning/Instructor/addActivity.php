<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Lesson');
define('PAGE', 'add lesson');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_instructor_login'])){
  $instructorEmail = $_SESSION['instructorLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['activitySubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['activity_title'] == "") || ($_REQUEST['course_id'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
  //  $activity_id = $_REQUEST['activity_id'];
   $activity_title = $_REQUEST['activity_title'];
   $course_id = $_REQUEST['course_id'];
   $activity_link = $_REQUEST['activity_link']; 
  //  $activity_link_temp = $_FILES['activity_link']['tmp_name'];
  //  $link_folder = '../activitylink/'.$activity_link; 
  //  move_uploaded_file($activity_link_temp, $link_folder);
    $sql = "INSERT INTO activity (activity_title, activity_link, course_id) VALUES ('$activity_title', '$activity_link', '$course_id')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Lesson Added Successfully </div>';
    } else {
     // below msg display on form submit failed
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
      <input type="text" class="form-control" id="course_id" name="course_id" value ="<?php if(isset($_SESSION['course_id'])){echo $_SESSION['course_id'];} ?>" readonly>
    </div>
    <div class="form-group">
      <label for="activity_title">Activity Title</label>
      <input type="text" class="form-control" id="activity_title" name="activity_title">
    </div>
    <div class="form-group">
      <label for="activity_link">Activity File Link</label>
      <input type="text" class="form-control-file" id="activity_link" name="activity_link">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="activitySubmitBtn" name="activitySubmitBtn">Submit</button>
      <a href="activity.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }

</script>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./instructorInclude/footer.php');
?>