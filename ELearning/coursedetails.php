<?php
include('./dbConnection.php');
include('./mainInclude/header.php');

if (!isset($_SESSION)) {
    session_start();
}

?>
<section style="height:98vh;">
<div class="container-fluid bg-dark">
    <div class="row"></div>
</div>
<br><br>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollModalLabel">Confirm Enrollment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <p>Enter your password to confirm enrollment:</p>
                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="confirmEnroll">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container mt-5" style="border:2px solid #e9ecef; border-radius:12px;">
    <?php
    if (isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
        $_SESSION['course_id'] = $course_id;

        $sql = "SELECT * FROM course WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <img src="' . htmlspecialchars(str_replace('..', '.', $row['course_img'])) . '" class="card-img-top" alt="Course Image" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title pt-3">Course Name: ' . htmlspecialchars($row['course_name']) . '</h5>
                            <p class="card-text">Description: ' . htmlspecialchars($row['course_desc']) . '</p>
                            <form action="" method="post">
                                <input type="hidden" name="course_id" value="' . htmlspecialchars($course_id) . '">
                                <button type="submit" class="btn btn-primary text-white font-weight-bolder float-right mb-3" name="enroll">Enroll</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
        }
        $stmt->close();
    }

    // Function to check if already enrolled
    function isAlreadyEnrolled($conn, $stu_id, $course_id) {
        $sql = "SELECT 1 FROM enrollees WHERE stu_id = ? AND course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $stu_id, $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Function to get student ID from email
    function getStudentIdByEmail($conn, $stu_email) {
        $sql = "SELECT stu_id FROM student WHERE stu_email = ?"; // Adjust table and column names if needed
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $stu_email); // Bind email parameter
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['stu_id']; // Return student ID
        } else {
            return null; // Return null if not found
        }
    }
    

    if (isset($_POST['enroll'])) {
        if (isset($_SESSION['is_login'])) {
            // Check if session has student ID or use email to fetch the ID
            if (isset($_SESSION['stu_id'])) {
                $stu_id = $_SESSION['stu_id']; // Get from session
            } elseif (isset($_SESSION['stuLogEmail'])) {
                // If student ID is not in session, fetch it using the email
                $stu_email = $_SESSION['stuLogEmail'];
                $stu_id = getStudentIdByEmail($conn, $stu_email);
            }

            if ($stu_id) {
                $course_id = $_POST['course_id'];
                $enrolment_date = date("Y-m-d");

                if (isAlreadyEnrolled($conn, $stu_id, $course_id)) {
                    echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "You have successfully enrolled in this course",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        Swal.close();
                    });
                </script>';
                } else {
                    $sql = "INSERT INTO enrollees (stu_id, course_id, enrolment_date) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iis", $stu_id, $course_id, $enrolment_date);

                    if ($stmt->execute()) {
                        echo '<script>
                        Swal.fire({
                            title: "Success!",
                            text: "You have successfully enrolled",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            Swal.close();
                        });
                    </script>';
                    } else {
                        echo "<script>alert('Enrollment failed. Please try again later.');</script>";
                    }
                    $stmt->close();
                }
            } else {
                echo "<script>alert('Unable to fetch student ID. Please log in again.');</script>";
            }
        } else {
            echo "<script>alert('You must be logged in to enroll.');</script>";
        }
    }
    ?>
</div>

<div class="container">
    <div class="row">
        <?php
        $sql = "SELECT * FROM lesson WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '
           <table class="table table-bordered table-hover">
             <thead>
               <tr>
                 <th scope="col">Lesson No.</th>
                 <th scope="col">Lesson Name</th>
               </tr>
             </thead>
             <tbody>';
            $num = 0;
            while ($row = $result->fetch_assoc()) {
                $num++;
                echo '<tr>
                    <th scope="row">' . $num . '</th>
                    <td>' . htmlspecialchars($row["lesson_name"]) . '</td>
                </tr>';
            }
            echo '</tbody>
           </table>';
        } else {
            echo "<p class='text-center'>No lessons available for this course.</p>";
        }

        $stmt->close();
        ?>         
    </div>
</div>
</section>

<?php
// Footer Include from mainInclude
include('./mainInclude/footer.php');
?>
