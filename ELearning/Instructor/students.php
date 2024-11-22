<?php
if (!isset($_SESSION)) {
  session_start();
}
define('TITLE', 'Students');
define('PAGE', 'students');
include('./instructorInclude/header.php');
include('../dbConnection.php');

if (isset($_SESSION['is_instructor_login'])) {
  $adminEmail = $_SESSION['instructorLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}
?>
<div class="col-sm-9 mt-5" style="margin-left:50px;">
  <!--Table-->
  <div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">

            <div class="col-lg-6 col-5 my-auto text-end">

            </div>
          </div>
        </div>
        <?php
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          //  echo '<table class="table">
          //  <thead>
          //   <tr>
          //    <th scope="col">Student ID</th>
          //    <th scope="col">Name</th>
          //    <th scope="col">Email</th>
          //    <th scope="col">Action</th>
          //   </tr>
          //  </thead>
          //  <tbody>';

          echo '<div class="card-body px-0 pb-2">
       <div class="table-responsive">
         <table class="table align-items-center mb-0">
           <thead>
             <tr>
               <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student ID</th>
               <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
               <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
               <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
             </tr>
           </thead>
           <tbody>';


          while ($row = $result->fetch_assoc()) {
            echo '  <tr>';
            echo '<td>
        <div class="d-flex px-2 py-1">
          <div>
            
          </div>
          <div class="d-flex flex-column justify-content-center">
            <h6 class="mb-0 text-sm text-center">' . $row["stu_id"] . '</h6>
          </div>
        </div>
      </td>';


            echo '<td>' . $row["stu_name"] . '</td>';


            echo '<td class="align-middle">
       ' . $row["stu_email"] . '
      </td>';

            echo '<td><form action="editstudent.php" method="POST" class="d-inline"> <input type="hidden" name="id" value=' . $row["stu_id"] . '><button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button></form>  
         <form action="" method="POST" class="d-inline"><input type="hidden" name="id" value=' . $row["stu_id"] . '><button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button></form></td>';

            echo '</tr>';
          }

          echo '</table>
  </div>
</div>
</div>
</div>';
        } else {
          echo "0 Result";
        }


        if (isset($_REQUEST['delete'])) {
          $sql = "DELETE FROM student WHERE stu_id = {$_REQUEST['id']}";
          if ($conn->query($sql) === TRUE) {
            // echo "Record Deleted Successfully";
            // below code will refresh the page after deleting the record
            echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
          } else {
            echo "Unable to Delete Data";
          }
        }
        ?>

    <div class="mt-3">
      <a class="btn btn-danger box" href="addnewstudent.php"><i class="fas fa-plus fa-2x"></i></a>
    </div>

      </div>
    </div> <!-- div Row close from header -->
    
  </div> <!-- div Conatiner-fluid close from header -->
  <?php
  include('./instructorInclude/footer.php');
  ?>