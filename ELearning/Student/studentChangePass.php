<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Change Password');
define('PAGE', 'studentChangePass');
include('./stuInclude/header.php'); 
include('../dbConnection.php');


if(isset($_SESSION['is_login'])){
  $stuEmail = $_SESSION['stuLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

if(isset($_REQUEST['stuPassUpdateBtn'])){
  
  if(($_REQUEST['stuNewPass'] == "" || $_REQUEST['stuPassConfirm'] == "")){
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    
    if($_REQUEST['stuNewPass'] !== $_REQUEST['stuPassConfirm']){
      $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Passwords do not match! </div>';
    } else {
      
      $stuPass = $_REQUEST['stuNewPass'];

      
      $sql = "SELECT * FROM student WHERE stu_email='$stuEmail'";
      $result = $conn->query($sql);

      if($result->num_rows == 1){
        
        $sql = "UPDATE student SET stu_pass = '$stuPass' WHERE stu_email = '$stuEmail'";

        if($conn->query($sql) === TRUE){
         
          $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Password Updated Successfully </div>';
        } else {
         
          $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update Password </div>';
        }
      } else {
        $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No such student found </div>';
      }
    }
  }
}
?>

<div class="col-sm-9 col-md-10">
  <div class="row">
    <div class="col-sm-6">
      <form class="mt-5 mx-5" method="POST">
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" value="<?php echo $stuEmail ?>" readonly>
        </div>
        <div class="form-group">
          <label for="inputnewpassword">New Password</label>
          <input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="stuNewPass" required>
        </div>
        <div class="form-group">
          <label for="stuPassConfirm">Confirm Password</label>
          <input type="password" class="form-control" id="stuPassConfirm" placeholder="Confirm Password" name="stuPassConfirm" required>
        </div>
        <button type="submit" class="btn btn-primary mr-4 mt-4" name="stuPassUpdateBtn">Update</button>
        <button type="reset" class="btn btn-secondary mt-4">Reset</button>
        <?php if(isset($passmsg)) { echo $passmsg; } ?>
      </form>
    </div>
  </div>
</div>

</div> 

<?php
include('./stuInclude/footer.php'); 
?>
