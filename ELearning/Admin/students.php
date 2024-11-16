<?php
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
  echo "<script>
      Swal.fire({
          icon: 'success',
          title: 'Student Deleted',
          text: 'The student has been successfully deleted.',
          showConfirmButton: false,
          timer: 1500
      });
  </script>";
  // Remove the flag by redirecting to the base URL
  echo "<script>
      window.history.replaceState(null, null, window.location.pathname);
  </script>";
}

define('TITLE', 'Students');
define('PAGE', 'students');
include('./adminInclude/header.php');
include('../dbConnection.php');

if (isset($_SESSION['is_admin_login'])) {
  $adminEmail = $_SESSION['adminLogEmail'];

} else {
  echo "<script> location.href='../index.php'; </script>";
}

if (isset($_POST['delete'])) {
  $adminPassword = $_POST['adminPassword'];
  $studentId = $_POST['studentId'];

  if (isset($adminEmail)) {
      $sql = "SELECT admin_pass FROM admin WHERE admin_email = '$adminEmail'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          $admin = $result->fetch_assoc();

          if ($adminPassword === $admin['admin_pass']) {
              $sql = "DELETE FROM student WHERE stu_id = $studentId";
              if ($conn->query($sql) === TRUE) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Student Deleted',
                        text: 'The student has been successfully deleted.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '?deleted=true'; // Redirect with a flag
                    });
                </script>";
            }
             else {
                  echo "<script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Unable to delete student. Please try again.',
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
          <input type="hidden" name="studentId" id="studentId" />
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
  <!--Table-->
  <div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-5 my-auto text-end"></div>
          </div>
        </div>
        <?php
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
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
            echo '<td class="align-middle">' . $row["stu_email"] . '</td>';
            echo '<td>
              <form action="editstudent.php" method="POST" class="d-inline"> 
                  <input type="hidden" name="id" value="' . $row["stu_id"] . '">
                  <button type="submit" class="btn btn-info mr-3" name="view" value="View">
                      <i class="fas fa-pen"></i>
                  </button>
              </form>  
              <button type="button" class="btn btn-danger delete-btn" data-id="' . $row["stu_id"] . '">
                  <i class="far fa-trash-alt"></i>
              </button>
            </td>';
            echo '</tr>';
          }

          echo '</tbody>
          </table>
        </div>
      </div>
    </div>';
        } else {
          echo "0 Result";
        }
        ?>

    <div class="mt-3">
      <a class="btn btn-danger box" href="addnewstudent.php"><i class="fas fa-plus fa-2x"></i></a>
    </div>

      </div>
    </div> <!-- div Row close from header -->
  </div> <!-- div Container-fluid close from header -->

  <script>
document.addEventListener('DOMContentLoaded', () => {
  const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Bootstrap modal instance

  document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function () {
          const studentId = this.getAttribute('data-id'); // Get student ID from data-id attribute
          document.getElementById('studentId').value = studentId; // Set the hidden input in the modal
          deleteModal.show(); // Show the modal
      });
  });
});

  </script>

  <?php
  include('./adminInclude/footer.php');
  ?>
