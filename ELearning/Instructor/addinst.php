<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
include_once('../dbConnection.php');

// setting header type to json, We'll be outputting a Json data
header('Content-type: application/json');


// Checking Email already Registered
if(isset($_POST['instLogEmail']) && isset($_POST['checkLogemail'])){
  $instemail = $_POST['instLogEmail'];
  
  $sql = "SELECT instructor_email FROM instructor WHERE instructor_email='".$instemail."'";
  $result = $conn->query($sql);
  $row = $result->num_rows;
  

  echo json_encode($row);
  }
 
  // Student Login Verification
  if(!isset($_SESSION['is_login'])){
    if(isset($_POST['checkLogemail']) && isset($_POST['instLogEmail']) && isset($_POST['instLogPass'])){
      $instLogEmail = $_POST['instLogEmail'];
      $instLogPass = $_POST['instLogPass'];
      
  echo json_encode($instLogEmail);
      $sql = "SELECT instructor_email, instructor_pass FROM instructor WHERE instructor_email='".$instLogEmail."' AND instructor_pass='".$instLogPass."'";
      $result = $conn->query($sql);
      $row = $result->num_rows;
      
      if($row === 1){
        $_SESSION['is_login'] = true;
        $_SESSION['instogEmail'] = $stuLogEmail;
        echo json_encode($row);
      } else if($row === 0) {
        echo json_encode($row);
      }
    }
  }

?>