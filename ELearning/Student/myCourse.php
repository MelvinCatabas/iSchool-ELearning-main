<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'my Course');
define('PAGE', 'myCourse');
include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

 if(isset($_SESSION['is_login'])){
  $stuLogEmail = $_SESSION['stuLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
?>

 <div class="container mt-5 ml-4">
  <div class="row">
   <div class="jumbotron">
    <h4 class="text-center">All Course</h4>
    <?php 
   if(isset($stuLogEmail)){

    $stu_sql = "SELECT stu_id FROM student WHERE stu_email = '$stuLogEmail'";
    $stu_result = $conn->query($stu_sql);
    $stu_row = $stu_result->fetch_assoc();
    $stu_id = $stu_row['stu_id'];
    
    $sql = "SELECT e.enrollee_id, c.course_id, c.course_name, c.course_desc, c.course_date, c.course_img, 
                   i.instructor_fname, i.instructor_lname 
            FROM enrollees AS e 
            JOIN course AS c ON c.course_id = e.course_id 
            JOIN instructor AS i ON i.instructor_id = c.instructor_id
            WHERE e.stu_id = '$stu_id'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
     while($row = $result->fetch_assoc()){ ?>
      <div class="bg-light mb-3">
        <h5 class="card-header"><?php echo $row['course_name']; ?></h5>
          <div class="row">
          
              <div class="col-sm-3">
                <img src="<?php echo $row['course_img']; ?>" class="card-img-top
                mt-4" alt="pic">
              </div>
              <div class="col-sm-6 mb-3">
                <div class="card-body">
                  <p class="card-title"><?php echo $row['course_desc']; ?></p>
                  <a href="watchcourse.php?course_id=<?php echo $row['course_id'] ?>" class="btn btn-primary mt-5 float-right">Watch Course</a>
                </div>
              </div>
          
          </div>
          
      </div> 
    <?php
     }
    }
   }
  
    ?>
    <hr/>
   </div>
  </div>
 </div>

 </div> <!-- Close Row Div from header file -->
 <?php
include('./stuInclude/footer.php'); 
?>