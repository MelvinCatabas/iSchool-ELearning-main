<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'edit student');
define('PAGE', 'edit student');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 // Update
 if(isset($_REQUEST['requpdate'])){
  // Checking for Empty Fields
  if(($_REQUEST['stu_id'] == "") || ($_REQUEST['stu_first_name'] == "") || ($_REQUEST['stu_last_name'] == "") || ($_REQUEST['stu_username'] == "") || ($_REQUEST['stu_dob'] == "") || ($_REQUEST['stu_sex'] == "") || ($_REQUEST['stu_program'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
    // Assigning User Values to Variable
    $sid = $_REQUEST['stu_id'];
    $stfname = $_REQUEST['stu_first_name'];
    $stlname = $_REQUEST['stu_last_name'];
    $stuser = $_REQUEST['stu_username'];
    $stdob = $_REQUEST['stu_dob'];
    $stex = $_REQUEST['stu_sex'];
    $stprogram = $_REQUEST['stu_program'];
    // $semail = $_REQUEST['stu_email'];
    // $spass = $_REQUEST['stu_pass'];
    // $socc = $_REQUEST['stu_occ'];
    
   $sql = "UPDATE student SET stu_id = '$sid', stu_first_name = '$stfname',  stu_last_name = '$stlname',  stu_username = '$stuser',  stu_dob = '$stdob',  stu_sex = '$stex',  stu_program = '$stprogram' WHERE stu_id = '$sid'";
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
  <h3 class="text-center">Update Student Details</h3>
  <?php
 if(isset($_REQUEST['view'])){
  $sql = "SELECT * FROM student WHERE stu_id = {$_REQUEST['id']}";
 $result = $conn->query($sql);
 $row = $result->fetch_assoc();
 }
 ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="stu_id">ID</label>
      <input type="text" class="form-control" id="stu_id" name="stu_id" value="<?php if(isset($row['stu_id'])) {echo $row['stu_id']; }?>"readonly>
    </div>
    <div class="form-group">
      <label for="stu_first_name">First Name</label>
      <input type="text" class="form-control" id="stu_first_name" name="stu_first_name" value="<?php if(isset($row['stu_first_name'])) {echo $row['stu_first_name']; }?>">
    </div>
    <div class="form-group">
      <label for="stu_last_name">Last Name</label>
      <input type="text" class="form-control" id="stu_last_name" name="stu_last_name" value="<?php if(isset($row['stu_last_name'])) {echo $row['stu_last_name']; }?>">
    </div>
    <div class="form-group">
      <label for="stu_username">Username</label>
      <input type="text" class="form-control" id="stu_username" name="stu_username" value="<?php if(isset($row['stu_username'])) {echo $row['stu_username']; }?>">
    </div>
    <div class="form-group">
      <label for="stu_dob">Date of Birth</label>
      <input type="date" class="form-control" id="stu_dob" name="stu_dob" value="<?php if(isset($row['stu_dob'])) {echo $row['stu_dob']; }?>">
    </div>

    <div class="form-outline mb-4">
            <label for="stuSex">Sex</label>
            <select class="form-control" id="stu_sex" name="stu_sex">
                <option value="Male" <?php if(isset($row['stu_sex'])) {echo $row['stu_sex']; } echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if(isset($row['stu_sex'])) {echo $row['stu_sex']; } echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if(isset($row['stu_sex'])) {echo $row['stu_sex']; } echo 'selected'; ?>>Other</option>
            </select>
        </div>

    <div class="form-group">
      <label for="stu_program">Program</label>
      <input type="text" class="form-control" id="stu_program" name="stu_program" value="<?php if(isset($row['stu_program'])) {echo $row['stu_program']; }?>">
    </div>

    <!-- <div class="form-group">
      <label for="stu_pass">Password</label>
      <input type="text" class="form-control" id="stu_pass" name="stu_pass" value="<?php if(isset($row['stu_pass'])) {echo $row['stu_pass']; }?>">
    </div> -->

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
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