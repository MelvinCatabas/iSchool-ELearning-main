<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Activity');
define('PAGE', 'activity');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_instructor_login'])){
  $adminEmail = $_SESSION['instructorLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 ?>

<div class="col-sm-9 mt-5  mx-3">
  <form action="" class="mt-3 form-inline d-print-none">
    <div class="form-group mr-3">
      <label for="checkid">Enter Course ID: </label>
      <input type="text" class="form-control ml-3" id="checkid" name="checkid" onkeypress="isInputNumber(event)">
    </div>
    <button type="submit" class="btn btn-danger">Search</button>
  </form>
  <?php
  $sql = "SELECT course_id FROM course";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()){
    if(isset($_REQUEST['checkid']) && $_REQUEST['checkid'] == $row['course_id']){
      $sql = "SELECT * FROM course WHERE course_id = {$_REQUEST['checkid']}";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      if(($row['course_id']) == $_REQUEST['checkid']){ 
        $_SESSION['course_id'] = $row['course_id'];
        $_SESSION['course_name'] = $row['course_name'];
        
        ?>
        <h3 class="mt-5  text-dark p-2" style="font-size:16px;">Course ID : <?php if(isset($row['course_id'])) {echo $row['course_id']; } ?> Course Name: <?php if(isset($row['course_name'])) {echo $row['course_name']; } ?></h3>

        <div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4" style="width:1400px;">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">

            <div class="col-lg-6 col-5 my-auto text-end">

            </div>
          </div>
        </div>
        <?php
          $sql = "SELECT * FROM activity WHERE course_id = {$_REQUEST['checkid']}";
          $result = $conn->query($sql);

            echo '<div class="card-body px-0 pb-2">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Activity ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Activity Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Activity Link</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                  </tr>
                </thead>
                <tbody>';
              while($row = $result->fetch_assoc()){
                echo '<tr>';
                echo '<th scope="row" style="text-align:center;">'.$row["activity_id"].'</th>';
                echo '<td>'. $row["activity_title"].'</td>';
                echo '<td>'.$row["activity_link"].'</td>';
                echo '<td><form action="editactivity.php" method="POST" class="d-inline"> <input type="hidden" name="id" value='. $row["activity_id"] .'><button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button></form>  
                <form action="" method="POST" class="d-inline"><input type="hidden" name="id" value='. $row["activity_id"] .'><button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button></form></td>
              </tr>';
              }
              echo '</tbody>
             </table>';
        } else {
          echo '<div class="alert alert-dark mt-4" role="alert">
          Course Not Found ! </div>';
        }
        if(isset($_REQUEST['delete'])){
         $sql = "DELETE FROM activity WHERE activity_id = {$_REQUEST['id']}";
         if($conn->query($sql) === TRUE){
           // echo "Record Deleted Successfully";
           // below code will refresh the page after deleting the record
           echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
           } else {
             echo "Unable to Delete Data";
           } 
     } 
   } 
  }?>

   <!-- div Row close from header -->
 <?php if(isset($_SESSION['course_id'])){
   echo '<div class="m-3"><a class="btn btn-danger box" href="./addActivity.php"><i class="fas fa-plus fa-2x"></i></a></div>';
   } ?>
  
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
 </div>  
 

 
</div>  <!-- div Conatiner-fluid close from header -->
<?php
  include('./instructorInclude/footer.php');
?>