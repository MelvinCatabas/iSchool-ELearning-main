<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Change Password');
define('PAGE', 'changepass');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');


if(isset($_SESSION['is_instructor_login'])){
  $instructorEmail = $_SESSION['instructorLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}


if(isset($_REQUEST['instructorPassUpdatebtn'])){
  
  if(($_REQUEST['instructorPass'] == "" || $_REQUEST['instructorPassConfirm'] == "")){
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Please fill in all fields. </div>';
  } else {

    if($_REQUEST['instructorPass'] !== $_REQUEST['instructorPassConfirm']){
      $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Passwords do not match. </div>';
    } else {
     
      $instructorPass = $_REQUEST['instructorPass'];

    
      $sql = "SELECT * FROM instructor WHERE instructor_email='$instructorEmail'";
      $result = $conn->query($sql);
      if($result->num_rows == 1){
        
        $sql = "UPDATE instructor SET instructor_pass = '$instructorPass' WHERE instructor_email = '$instructorEmail'";
        if($conn->query($sql) == TRUE){
         
          $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Password updated successfully. </div>';
        } else {
        
          $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to update password. </div>';
        }
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
          <input type="email" class="form-control" id="inputEmail" value="<?php echo $instructorEmail ?>" readonly>
        </div>
        <div class="form-group">
          <label for="inputnewpassword">New Password</label>
          <input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="instructorPass" required>
        </div>
        <div class="form-group">
          <label for="inputnewpasswordConfirm">Confirm Password</label>
          <input type="password" class="form-control" id="inputnewpasswordConfirm" placeholder="Confirm Password" name="instructorPassConfirm" required>
        </div>
        <button type="submit" class="btn btn-danger mr-4 mt-4" name="instructorPassUpdatebtn">Update</button>
        <button type="reset" class="btn btn-secondary mt-4">Reset</button>
        <?php if(isset($passmsg)) { echo $passmsg; } ?>
      </form>
    </div>
  </div>
</div>

<?php
include('./instructorInclude/footer.php');
?>
