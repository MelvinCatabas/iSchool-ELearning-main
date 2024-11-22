<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Change Password');
define('PAGE', 'changepass');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

// Check if user is logged in
if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

if(isset($_REQUEST['adminPassUpdatebtn'])){
  
  if(($_REQUEST['adminPass'] == "" || $_REQUEST['instpass-confirm'] == "")){
  
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {

    if($_REQUEST['adminPass'] !== $_REQUEST['instpass-confirm']){
      $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Passwords do not match! </div>';
    } else {
      
      $adminPass = $_REQUEST['adminPass'];  

    
      $sql = "SELECT * FROM admin WHERE admin_email='$adminEmail'";
      $result = $conn->query($sql);
      
      if($result->num_rows == 1){
    
        $sql = "UPDATE admin SET admin_pass = '$adminPass' WHERE admin_email = '$adminEmail'";
        if($conn->query($sql) == TRUE){
         
          $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Password Updated Successfully </div>';
        } else {
        
          $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update Password </div>';
        }
      } else {
      
        $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Admin not found. </div>';
      }
    }
  }
}
?>

<div class="col-sm-9 mt-5">
  <div class="row">
    <div class="col-sm-6">
      <form method="POST" class="mt-5 mx-5">
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" value="<?php echo $adminEmail ?>" readonly>
        </div>
        <div class="form-group">
          <label for="inputnewpassword">New Password</label>
          <input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="adminPass">
        </div>
        <div class="form-group">
          <label for="instpass-confirm">Confirm Password</label>
          <input type="password" class="form-control" id="instpass-confirm" placeholder="Confirm Password" name="instpass-confirm">
        </div>
        <button type="submit" class="btn btn-danger mr-4 mt-4" name="adminPassUpdatebtn">Update</button>
        <button type="reset" class="btn btn-secondary mt-4">Reset</button>
        <?php if(isset($passmsg)) { echo $passmsg; } ?>
      </form>
    </div>
  </div>
</div>

<?php include('./adminInclude/footer.php'); ?>
