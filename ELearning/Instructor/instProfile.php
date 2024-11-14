<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Student Profile');
define('PAGE', 'profile');
include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

 if(isset($_SESSION['is_login'])){
  $stuEmail = $_SESSION['stuLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }

 $sql = "SELECT * FROM student WHERE stu_email='$instEmail'";
 $result = $conn->query($sql);
 if($result->num_rows == 1){
 $row = $result->fetch_assoc();
 $instId = $row["instructor_is"];
 $instName = $row["instructor_fname"]; 
//  $stuOcc = $row["stu_occ"];
 $instImg = $row["instructor_img"];

}

 if(isset($_REQUEST['updateInstNameBtn'])){
  if(($_REQUEST['instructor_fname'] == "")){
   // msg displayed if required field missing
   $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   $instName = $_REQUEST["instructor_fname"];
  //  $stuOcc = $_REQUEST["stuOcc"];
   $inst_image = $_FILES['instructor_img']['instructor_fname']; 
   $inst_image_temp = $_FILES['instructor_img']['instructor_fname'];
   $img_folder = '../image/stu/'. $inst_image; 
   move_uploaded_file($inst_image_temp, $img_folder);
   $sql = "UPDATE student SET instructor_fname = '$instName',  instructor_img = '$img_folder' WHERE instructor_email = '$instEmail'";
   if($conn->query($sql) == TRUE){
   // below msg display on form submit success
   $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
   } else {
   // below msg display on form submit failed
   $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
      }
    }
 }

?>
 <div class="col-sm-6 mt-5">
  <form class="mx-5" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="stuId">Student ID</label>
      <input type="text" class="form-control" id="instId" name="instId" value=" <?php if(isset($instId)) {echo $instId;} ?>" readonly>
    </div>
    <div class="form-group">
      <label for="stuEmail">Email</label>
      <input type="email" class="form-control" id="instEmail" value=" <?php echo $instEmail ?>" readonly>
    </div>
    <div class="form-group">
      <label for="stuName">Name</label>
      <input type="text" class="form-control" id="instName" name="instName" value=" <?php if(isset($instName)) {echo $instName;} ?>">
    </div>
  
    <div class="form-group">
      <label for="stuImg">Upload Image</label>
      <input type="file" class="form-control-file" id="instImg" name="instImg">
    </div>
    <button type="submit" class="btn btn-primary" name="updateInstNameBtn">Update</button>
    <?php if(isset($passmsg)) {echo $passmsg; } ?>
  </form>
 </div>

 </div> <!-- Close Row Div from header file -->

 <?php
include('./stuInclude/footer.php'); 
?>