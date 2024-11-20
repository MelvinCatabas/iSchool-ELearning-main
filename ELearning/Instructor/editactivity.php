<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Edit Lesson');
define('PAGE', 'edit lesson');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_instructor_login'])){
  $adminEmail = $_SESSION['instructorLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 // Update
 if(isset($_REQUEST['requpdate'])){
  // Checking for Empty Fields
  if(($_REQUEST['activity_id'] == "") || ($_REQUEST['activity_title'] == "") ||  ($_REQUEST['course_id'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
    // Assigning User Values to Variable
    $activity_id = $_REQUEST['activity_id'];
    $activity_title = $_REQUEST['activity_title'];
    $activity_link = $_REQUEST['activity_link'];
    // $llink = '../activitylink/'. $_FILES['activity_link']['name'];
    $cid = $_REQUEST['course_id'];
    // $cname = $_REQUEST['course_name'];
    
    
   $sql = "UPDATE activity SET activity_id = '$activity_id', activity_title = '$activity_title', activity_link = '$activity_link', course_id='$cid' WHERE activity_id = '$activity_id'";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Update Activity Details</h3>
  <?php
 if(isset($_REQUEST['view'])){
  $sql = "SELECT * FROM activity WHERE activity_id = {$_REQUEST['id']}";
 $result = $conn->query($sql);
 $row = $result->fetch_assoc();
 }
 ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="activity_id">Activity ID</label>
      <input type="text" class="form-control" id="activity_id" name="activity_id" value="<?php if(isset($row['activity_id'])) {echo $row['activity_id']; }?>" readonly>
    </div>
    <div class="form-group">
      <label for="activity_title">Activity Title</label>
      <input type="text" class="form-control" id="activity_title" name="activity_title" value="<?php if(isset($row['activity_title'])) {echo $row['activity_title']; }?>">
    </div>

    <div class="form-group">
      <label for="activity_link">Activity Link</label>
      <input type="text" class="form-control" id="activity_link" name="activity_link" value="<?php if(isset($row['activity_link'])) {echo $row['activity_link']; }?>">
    </div>
    <div class="form-group">
      <label for="course_id">Course ID</label>
      <input type="text" class="form-control" id="course_id" name="course_id" value="<?php if(isset($row['course_id'])) {echo $row['course_id']; }?>" readonly>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
      <a href="activity.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
  include('./instructorInclude/footer.php');
?>