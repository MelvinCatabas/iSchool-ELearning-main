<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Courses');
define('PAGE', 'courses');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

if(isset($_POST['delete'])){
  $adminPassword = $_POST['adminPassword'];
  $courseId = $_POST['courseId'];

  if(isset($adminEmail)){
    $sql = "SELECT admin_pass FROM admin WHERE admin_email = '$adminEmail'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
      $admin = $result->fetch_assoc();

      if($adminPassword === $admin['admin_pass']){
        $sql = "DELETE FROM enrollees WHERE course_id = $courseId;";
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
                    text: 'Please enter the correct admin password.',
                });
            </script>";
      }
    } else {
      echo "<script>
              Swal.fire({
                  icon: 'error',
                  title: 'Admin Not Found',
                  text: 'No admin found with the provided email.',
              });
          </script>";
    }
  } else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Session Error',
                text: 'Admin email not set in session.',
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
          <input type="password" name="adminPassword" class="form-control" placeholder="Admin Password" required />
          <input type="hidden" name="courseId" id="courseId" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="delete" class="btn btn-danger">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-sm-9 mt-5" style="margin-left:50px;">
  <!-- Table for Courses -->
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
          $sql = "SELECT * FROM course";
          $result = $conn->query($sql);
          if($result->num_rows > 0){
            echo '<div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                      <table class="table align-items-center mb-0">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Course Name</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                          </tr>
                        </thead>
                        <tbody>';

            while($row = $result->fetch_assoc()){
              echo '<tr>';
              echo '<td class="text-center">'.$row["course_id"].'</td>';
              echo '<td>'.$row["course_name"].'</td>';
              echo '<td>
                      <form action="editcourse.php" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="'.$row["course_id"].'">
                        <button type="submit" class="btn btn-info mr-3" name="view" value="View">
                          <i class="fas fa-pen"></i>
                        </button>
                      </form>
                      <button type="button" class="btn btn-danger delete-btn" data-id="'.$row["course_id"].'">
                        <i class="far fa-trash-alt"></i>
                      </button>
                    </td>';
              echo '</tr>';
            }

            echo '</tbody>
            </table>
          </div>
        </div>';
          } else {
            echo "0 Result";
          }
        ?>

        <div class="mt-3">
          <a class="btn btn-danger box mx-3" href="addCourse.php"><i class="fas fa-plus fa-2x"></i></a>
        </div>
      </div>
    </div> <!-- div Row close -->
  </div> <!-- div Container-fluid close -->
</div>

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
include('./adminInclude/footer.php');
?>
