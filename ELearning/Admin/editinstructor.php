<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Edit Instructor Course');
define('PAGE', 'edit instructor course');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } 
 else {
  echo "<script> location.href='../index.php'; </script>";
 }
 // Update
 if(isset($_REQUEST['requpdate'])){
  // Checking for Empty Fields
  if(($_REQUEST['instructor_fname'] == "") || ($_REQUEST['instructor_lname'] == "")|| ($_REQUEST['instructor_dob'] == "")|| ($_REQUEST['instructor_sex'] == "")|| ($_REQUEST['instructor_email'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
    // Assigning User Values to Variable
    $instructor_id = $_REQUEST['instructor_id'];
    $instructor_fname = $_REQUEST['instructor_fname'];
    $instructor_lname = $_REQUEST['instructor_lname'];
    $instructor_dob = $_REQUEST['instructor_dob'];
    $instructor_sex = $_REQUEST['instructor_sex'];
    $instructor_email = $_REQUEST['instructor_email'];
    $instructor_pass = $_REQUEST['instructor_pass'];
    $cimg = '../image/instimg/'. $_FILES['instructor_img']['name'];
    
   $sql = "UPDATE instructor SET instructor_id = '$instructor_id', instructor_fname = '$instructor_fname', instructor_lname = '$instructor_lname', instructor_dob = '$instructor_dob' , instructor_sex = '$instructor_sex' , instructor_email = '$instructor_email', instructor_img = '$cimg'   WHERE instructor_id = '$instructor_id'";
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
  <h3 class="text-center">Update Instructor Details</h3>
  <?php
 if(isset($_REQUEST['view'])){
  $sql = "SELECT * FROM instructor WHERE instructor_id = {$_REQUEST['id']}";
 $result = $conn->query($sql);
 $row = $result->fetch_assoc();
 }
 ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="course_id">Instructor ID</label>
      <input type="text" class="form-control" id="instructor_id" name="instructor_id" value="<?php if(isset($row['instructor_id'])) {echo $row['instructor_id']; }?>" readonly>
    </div>
    <div class="form-group">
      <label for="instructor_fname">Instructor First Name</label>
      <input type="text" class="form-control" id="instructor_fname" name="instructor_fname" value="<?php if(isset($row['instructor_fname'])) {echo $row['instructor_fname']; }?>">
    </div>
    <div class="form-group">
      <label for="instructor_lname">Instructor Last Name</label>
      <input type="text" class="form-control" id="instructor_lname" name="instructor_lname" value="<?php if(isset($row['instructor_lname'])) {echo $row['instructor_lname']; }?>">
    </div>
    <div class="form-group">
      <label for="instructor_dob">Instructor DOB</label>
      <input type="date" class="form-control" id="instructor_dob" name="instructor_dob" value="<?php if(isset($row['instructor_dob'])) {echo $row['instructor_dob']; }?>">
    </div>
    <div class="form-group">
      <label for="instructor_sex">Instructor Sex</label>
      <input type="text" class="form-control" id="instructor_sex" name="instructor_sex" value="<?php if(isset($row['instructor_sex'])) {echo $row['instructor_sex']; }?>">
    </div>
    <div class="form-group">
      <label for="instructor_email">Instructor Email</label>
      <input type="text" class="form-control" id="instructor_email" name="instructor_email" value="<?php if(isset($row['instructor_email'])) {echo $row['instructor_email']; }?>">
    </div>
    <div class="form-group">
      <label for="instructor_img">Instructor Image</label>
      <img src="<?php if(isset($row['instructor_img'])) {echo $row['instructor_img']; }?>" alt="instructorimage" class="img-thumbnail">     
      <input type="file" class="form-control-file" id="instructor_img" name="instructor_img">
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
      <a href="instructor.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./adminInclude/footer.php'); 
?>