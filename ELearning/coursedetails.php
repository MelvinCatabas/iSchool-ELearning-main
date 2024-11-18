<?php
include('./dbConnection.php');
// Header Include from mainInclude
include('./mainInclude/header.php'); 
?>  
<div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
    <div class="row"></div> 
</div> <!-- End Course Page Banner -->
<br><br>
<div class="container mt-5" style="border:2px solid #e9ecef; border-radius:12px;"> <!-- Start All Course -->
    <?php
    if (isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
        $_SESSION['course_id'] = $course_id;
        $sql = "SELECT * FROM course WHERE course_id = '$course_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) { 
            while ($row = $result->fetch_assoc()) {
                echo ' 
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Guitar" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Course Name: ' . $row['course_name'] . '</h5>
                            <p class="card-text"> Description: ' . $row['course_desc'] . '</p>
                            <form action="" method="post">
                                <input type="hidden" name="course_id" value="' . $course_id . '">
                                <button type="submit" class="btn btn-primary text-white font-weight-bolder float-right mb-3" name="enroll">Enroll</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
        }
    }

    // Enrollment logic
    if (isset($_POST['enroll'])) {
        if (isset($_SESSION['is_login'])) {
            $stu_id = $_SESSION['is_login'];
            $course_id = $_POST['course_id'];

            // Check if the student is already enrolled
            $check_sql = "SELECT * FROM enrollees WHERE stu_id = ? AND course_id = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("ii", $stu_id, $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('You are already enrolled in this course!');</script>";
            } else {
                // Insert enrollment
                $enroll_sql = "INSERT INTO enrollees (stu_id, course_id) VALUES (?, ?)";
                $stmt = $conn->prepare($enroll_sql);
                $stmt->bind_param("ii", $stu_id, $course_id);

                if ($stmt->execute()) {
                    echo "<script>alert('Successfully enrolled!');</script>";
                } else {
                    echo "<script>alert('Enrollment failed. Please try again later.');</script>";
                }
            }

            $stmt->close();
        } else {
            echo "<script>alert('You must be logged in to enroll.');</script>";
        }
    }
    ?>
</div><!-- End All Course -->

<div class="container">
    <div class="row">
        <?php
        $sql = "SELECT * FROM lesson";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '
           <table class="table table-bordered table-hover">
             <thead>
               <tr>
                 <th scope="col">Lesson No.</th>
                 <th scope="col" style="border: none">Lesson Name</th>
               </tr>
             </thead>
             <tbody>';
            $num = 0;
            while ($row = $result->fetch_assoc()) {
                if ($row['course_id'] == $course_id) {
                    $num++;
                    echo '<tr>
               <th scope="row">' . $num . '</th>
               <td style="border: none">' . $row["lesson_name"] . '  </td>
               <td style="border: none"><b>:</b></td></tr>';
                }
            }
            echo '</tbody>
           </table>';
        }
        ?>         
    </div>
</div>  
<?php 
// Footer Include from mainInclude 
// include('./mainInclude/footer.php'); 
?>
