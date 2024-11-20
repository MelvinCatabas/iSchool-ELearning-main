<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Lesson');
define('PAGE', 'add lesson');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_instructor_login']) || isset($_GET['course_id'])){
  $instructorEmail = $_SESSION['instructorLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['lessonSubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['lesson_name'] == "") || ($_REQUEST['lesson_desc'] == "") || ($_REQUEST['course_id'] == "") ){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
   $lesson_name = $_REQUEST['lesson_name'];
   $lesson_desc = $_REQUEST['lesson_desc'];
   $course_id = $_GET['course_id'];
   $lesson_link = $_REQUEST['lesson_link']; 
  //  $lesson_link_temp = $_FILES['lesson_link']['tmp_name'];
  //  $link_folder = '../lessonvid/'.$lesson_link; 
  //  move_uploaded_file($lesson_link_temp, $link_folder);
    $sql = "INSERT INTO lesson (lesson_name, lesson_desc, lesson_link, course_id) VALUES ('$lesson_name', '$lesson_desc','$lesson_link', '$course_id')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Lesson Added Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Lesson </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Lesson</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="course_id">Course ID</label>
      <input type="text" class="form-control" id="course_id" name="course_id" value ="<?php if(isset($_GET['course_id'])){echo $_GET['course_id'];} ?>">
    </div>
    <!-- <div class="form-group">
      <label for="course_name">Course Name</label>
      <input type="text" class="form-control" id="course_name" name="course_name" value ="<?php if(isset($_SESSION['course_name'])){echo $_SESSION['course_name'];} ?>">
    </div> -->
    <div class="form-group">
      <label for="lesson_name">Lesson Name</label>
      <input type="text" class="form-control" id="lesson_name" name="lesson_name">
    </div>
    <div class="form-group">
      <label for="lesson_desc">Lesson Description</label>
      <textarea class="form-control" id="lesson_desc" name="lesson_desc" row=2></textarea>
    </div>
    <div class="form-group">
      <label for="lesson_link">Lesson Video Link</label>
      <input type="text" class="form-control" id="lesson_link" name="lesson_link">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="lessonSubmitBtn" name="lessonSubmitBtn">Submit</button>
      <a href="lessons.php" class="btn btn-secondary">Close</a>
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
include('./instructorInclude/footer.php');
?>