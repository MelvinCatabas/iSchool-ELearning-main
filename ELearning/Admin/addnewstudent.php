<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Student');
define('PAGE', 'add student');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['newStuSubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['stu_first_name'] == "") || ($_REQUEST['stu_last_name'] == "") || ($_REQUEST['stu_username'] == "") || ($_REQUEST['stu_dob'] == "") || ($_REQUEST['stu_sex'] == "") || ($_REQUEST['stu_email'] == "") || ($_REQUEST['stu_pass'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
   
   $stu_fname = $_REQUEST['stu_first_name'];
   $stu_lname = $_REQUEST['stu_last_name'];
   $stu_username = $_REQUEST['stu_username'];
   $stu_dob = $_REQUEST['stu_dob'];
   $stu_sex = $_REQUEST['stu_sex'];
   $stu_email = $_REQUEST['stu_email'];
   $stu_pass = $_REQUEST['stu_pass'];

    $sql = "INSERT INTO student (stu_first_name, stu_last_name, stu_username, stu_dob, stu_sex, stu_email, stu_pass) VALUES ('$stu_fname', '$stu_lname', '$stu_username', '$stu_dob', '$stu_sex', '$stu_email', '$stu_pass')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Student Added Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Student </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Student</h3>
  <form action="" method="POST" enctype="multipart/form-data">

    <div class="form-group">
      <label for="stu_first_name">First Name</label>
      <input type="text" class="form-control" id="stu_first_name" name="stu_first_name">
    </div>

    <div class="form-group">
      <label for="stu_last_name">Last Name</label>
      <input type="text" class="form-control" id="stu_last_name" name="stu_last_name">
    </div>

    <div class="form-group">
      <label for="stu_username">Username</label>
      <input type="text" class="form-control" id="stu_username" name="stu_username">
    </div>

    <div class="form-group">
      <label for="stu_dob">Date of Birth</label>
      <input type="date" class="form-control" id="stu_dob" name="stu_dob">
    </div>

    <div class="form-outline mb-4">
            <label class="form-label" for="stu_sex">Sex</label>
            <select class="form-control form-control-lg" style="height:40px; font-size:16px;" name="stu_sex" id="stu_sex">
              <option value="" disabled selected>Select your sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>

    <div class="form-group">
      <label for="stu_email">Email</label>
      <input type="text" class="form-control" id="stu_email" name="stu_email">
    </div>
    <div class="form-group">
      <label for="stu_pass">Password</label>
      <input type="text" class="form-control" id="stu_pass" name="stu_pass">
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="newStuSubmitBtn" name="newStuSubmitBtn">Submit</button>
      <a href="students.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./adminInclude/footer.php'); 
?>