<?php
if (!isset($_SESSION)) { 
  session_start(); 
}
define('TITLE', 'Courses');
define('PAGE', 'courses');
include('./instructorInclude/header.php'); 
include('../dbConnection.php');

if (isset($_SESSION['is_instructor_login'])) {
  $instructorEmail = $_SESSION['instructorLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

$sqlInstructor = "SELECT instructor_id FROM instructor WHERE instructor_email = '$instructorEmail'";
$resultInstructor = $conn->query($sqlInstructor);

if ($resultInstructor->num_rows == 1) {
    $rowInstructor = $resultInstructor->fetch_assoc();
    $instructorId = $rowInstructor['instructor_id'];
} else {
    echo "Instructor not found.";
    exit;
}


if(isset($_POST['delete'])){
  $instructorPassword = $_POST['instructorPassword'];
  $courseId = $_POST['courseId'];

  if(isset($instructorEmail)){
    $sql = "SELECT instructor_pass FROM instructor WHERE instructor_email = '$instructorEmail'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
      $instructor = $result->fetch_assoc();

      if($instructorPassword === $instructor['instructor_pass']){
        $sql = "DELETE FROM activity WHERE course_id = $courseId;";
        $sql .= "DELETE FROM lesson WHERE course_id = $courseId;";
        $sql .= "DELETE FROM enrollees WHERE course_id = $courseId;";
        $sql .= "DELETE FROM course WHERE course_id = $courseId;";

        if($conn->multi_query($sql) === TRUE){
          echo "<script>
                  Swal.fire({
                      icon: 'success',
                      title: 'Course Deleted',
                      text: 'The course has been successfully deleted.',
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location.href = '?deleted=true';
                  });
              </script>";

              echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
        } else {
          echo "<script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Unable to delete course. Please try again.',
                  });
              </script>";
        }
      } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Incorrect Password',
                    text: 'Please enter the correct Instructor password.',
                });
            </script>";
      }
    } else {
      echo "<script>
              Swal.fire({
                  icon: 'error',
                  title: 'Instructor Not Found',
                  text: 'No Instructor found with the provided email.',
              });
          </script>";
    }
  } else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Session Error',
                text: 'Instructor email not set in session.',
            });
        </script>";
  }
}


?>

<!-- Modal for Deletion Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="">
      <p>Enter your password to confirm the deletion:</p>
          <input type="password" name="instructorPassword" class="form-control" placeholder="instructor Password" required />
          <input type="hidden" name="courseId" id="courseId" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-sm-9 mt-5" style="margin-left:50px;">
  <!-- Table -->
  <div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4" style="width:1200px;">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-5 my-auto text-end">
            </div>
          </div>
        </div>
<?php
$sql = "SELECT * FROM course WHERE instructor_id = $instructorId";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo '<div class="card-body px-0 pb-2">
    <div class="table-responsive">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course ID</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Course Name</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
          </tr>
        </thead>
        <tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<th scope="row" style="text-align:center;">' . $row["course_id"] . '</th>';
        echo '<td>' . $row["course_name"] . '</td>';
        echo '<td>
                <form action="editcourse.php" method="POST" class="d-inline">
                  <input type="hidden" name="id" value="' . $row["course_id"] . '">
                  <button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button>
                </form>  
                <button class="btn btn-secondary delete-btn" data-id="' . $row["course_id"] . '" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="far fa-trash-alt"></i></button>
              </td>';
        echo '</tr>';
    }

    echo '</tbody>
      </table>';
} else {
    echo "0 Results";
}

?>
<div class="m-3">
  <a class="btn btn-danger box" href="./addCourse.php"><i class="fas fa-plus fa-2x"></i></a>
</div>
  </div>
</div> <!-- div Row close from header -->

</div> <!-- div Container-fluid close from header -->

<script>
document.addEventListener('DOMContentLoaded', () => {
  const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Bootstrap modal instance

  document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function () {
          const courseId = this.getAttribute('data-id'); // Get course ID from data-id attribute
          document.getElementById('courseId').value = courseId; // Set the hidden input in the modal
          deleteModal.show(); // Show the modal
      });
  });
});
</script>

<?php
include('./instructorInclude/footer.php');
?>
