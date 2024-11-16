<?php 
include('../dbConnection.php');
if(!isset($_SESSION)){ 
  session_start(); 
}
// setting header type to json, We'll be outputting a Json data
header('Content-type: application/json');

 // Admin Login Verification
 if(!isset($_SESSION['is_instructor_login'])){
   if(isset($_POST['checkLogemail']) && isset($_POST['instructorLogEmail']) && isset($_POST['instructorLogPass'])){
     $instructorLogEmail = $_POST['instructorLogEmail'];
     $instructorLogPass = $_POST['instructorLogPass'];
     $sql = "SELECT instructor_email, instructor_pass FROM instructor WHERE instructor_email='".$instructorLogEmail."' AND instructor_pass='".$instructorLogPass."'";
     $result = $conn->query($sql);
     $row = $result->num_rows;
     
     if($row === 1){
       $_SESSION['is_instructor_login'] = true;
       $_SESSION['instructorLogEmail'] = $instructorLogEmail;
       echo json_encode($row);
     } else if($row === 0) {
       echo json_encode($row);
     }
   }
 }

?>