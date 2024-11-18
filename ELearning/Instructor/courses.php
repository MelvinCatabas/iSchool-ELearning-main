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
        <p>Are you sure you want to delete this course? This action cannot be undone.</p>
        <form method="POST" action="">
          <input type="hidden" name="courseId" id="courseId" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="confirmDelete" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-sm-9 mt-5" style="margin-left:50px;">
  <!-- Table -->
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
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
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

// Deletion Handling
if (isset($_POST['confirmDelete'])) {
  $courseId = intval($_POST['courseId']); // Sanitize input
  error_log("Deleting Course ID: " . $courseId); // Debugging

  $sql = "DELETE FROM activity WHERE course_id = $courseId;";
  $sql .= "DELETE FROM lesson WHERE course_id = $courseId;";
  $sql .= "DELETE FROM enrollees WHERE course_id = $courseId;";
  $sql .= "DELETE FROM course WHERE course_id = $courseId;";

  // Log the SQL query for debugging
  error_log("Executing SQL: " . $sql);

  // Execute the query
  if ($conn->multi_query($sql)) {
      do {
          if ($result = $conn->store_result()) {
              $result->free();
          }
      } while ($conn->more_results() && $conn->next_result());

      echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
  } else {
      error_log("SQL Error: " . $conn->error); // Log the error
      echo "Unable to Delete Data: " . $conn->error; // Display error
  }
}

?>
<div class="m-3">
  <a class="btn btn-danger box" href="./addCourse.php"><i class="fas fa-plus fa-2x"></i></a>
</div>
  </div>
</div> <!-- div Row close from header -->

</div> <!-- div Container-fluid close from header -->

<script>
  // JavaScript to set course ID in the modal
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', () => {
      const courseId = button.getAttribute('data-id');
      document.getElementById('courseId').value = courseId;
    });
  });
  
</script>

<?php
include('./instructorInclude/footer.php');
?>
