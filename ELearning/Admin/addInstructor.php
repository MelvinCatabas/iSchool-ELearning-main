<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Instructor');
define('PAGE', 'add instructor');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['instructorSubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['instructor_fname'] == "") || ($_REQUEST['instructor_lname'] == "")|| ($_REQUEST['instructor_dob'] == "")|| ($_REQUEST['instructor_sex'] == "")|| ($_REQUEST['instructor_email'] == "") || ($_REQUEST['instructor_pass'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
   $instructor_fname = $_REQUEST['instructor_fname'];
   $instructor_lname = $_REQUEST['instructor_lname'];
   $instructor_dob = $_REQUEST['instructor_dob'];
   $instructor_sex = $_REQUEST['instructor_sex'];
   $instructor_email = $_REQUEST['instructor_email'];
   $instructor_pass = $_REQUEST['instructor_pass'];
   $instructor_image = $_FILES['instructor_img']['name']; 
   $instructor_image_temp = $_FILES['instructor_img']['tmp_name'];
   $img_folder = '../image/instimg/'. $instructor_image; 
   move_uploaded_file($instructor_image_temp, $img_folder);
    $sql = "INSERT INTO instructor (instructor_fname, instructor_lname, instructor_dob, instructor_sex, instructor_email, instructor_pass, instructor_img) VALUES ('$instructor_fname', '$instructor_lname','$instructor_dob', '$instructor_sex','$instructor_email', '$instructor_pass', '$img_folder')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Instructor Added Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Instructor </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Instructor</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="instructor_fname">Instructor First Name</label>
      <input type="text" class="form-control" id="instructor_fname" name="instructor_fname">
    </div>
    <div class="form-group">
      <label for="instructor_lname">Instructor Last Name</label>
      <input type="text" class="form-control" id="instructor_lname" name="instructor_lname">
    </div>
    <div class="form-group">
      <label for="instructor_dob">Instructor Date of Birth</label>
      <input type="date" class="form-control" id="instructor_dob" name="instructor_dob">
    </div>
    <div class="form-outline mb-4">
            <label class="form-label" for="instructor_sex">Sex</label>
            <select class="form-control form-control-lg" style="height:40px; font-size:16px;" name="instructor_sex" id="instructor_sex">
              <option value="" disabled selected>Select your sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
    <div class="form-group">
      <label for="instructor_email">Instructor Email</label>
      <input type="text" class="form-control" id="instructor_email" name="instructor_email">
    </div>
    <div class="form-group">
      <label for="instructor_pass">Instructor Password</label>
      <input type="text" class="form-control" id="instructor_pass" name="instructor_pass">
    </div>
    <div class="form-group">
      <label for="instructor_img">Instructor Image</label>
      <input type="file" class="form-control-file" id="instructor_img" name="instructor_img">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="instructorSubmitBtn" name="instructorSubmitBtn">Submit</button>
      <a href="instructor.php" class="btn btn-secondary">Close</a>
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
include('./adminInclude/footer.php'); 
?>