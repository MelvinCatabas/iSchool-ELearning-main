<?php
// include('./config.php');
include('./dbConnection.php');

// Header Include from mainInclude 
include('./mainInclude/headerinst.php');
?>

<link rel="stylesheet" href="./css/style.css">

<!-- Start Video Background -->
<?php
if (!isset($_SESSION['is_login'])) {
    echo '<div class="container-fluid remove-vid-marg">
              <div class="vid-parent">
                <video playsinline autoplay muted loop>
                  <source src="video/neust.mp4" />
                </video>
                <div class="vid-overlay"></div>
              </div>
              <div class="vid-content pl-3">
                <h1 class="my-content">Welcome to <b>NEUST</b></h1>
                <small class="my-content" style="font-size:16px;">Learn and Implement</small><br />';
    echo '<a class="btn btns mt-3" href="#" data-toggle="modal" data-target="#adminLoginModalCenter">Admin Login</a>';
    echo '</div>
          </div>';
}
?>

<!-- Course Display Logic -->
<?php
if (isset($_SESSION['is_login'])) {
    if (isset($_GET['view_all']) && $_GET['view_all'] == 'true') {
        $sql = "SELECT * FROM course";
        $buttonText = "Limit View";
    } else {
        $sql = "SELECT * FROM course LIMIT 4";
        $buttonText = "View All Courses";
    }

    $result = $conn->query($sql);

    echo '<div class="container-fluid py-5 my-5">
            <div class="row">';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $course_id = $row['course_id'];
            $instructor_id = $row['instructor_id'];

            // Fetch instructor details
            $instructor_sql = "SELECT * FROM instructor WHERE instructor_id = ?";
            $stmt = $conn->prepare($instructor_sql);
            $stmt->bind_param("i", $instructor_id);
            $stmt->execute();
            $instructor_result = $stmt->get_result();
            $instructor = $instructor_result->fetch_assoc();

            echo '
            <!-- Course Card -->
            <a href="coursedetails.php?course_id=' . $course_id . '" class="col-md-3 mb-3">
                <div class="card" style="height:400px">
                    <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Course Image"/>
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['course_name']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($row['course_desc']) . '</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div>
                            <img src="' . str_replace('..', '.', $instructor['instructor_img']) . '" alt="Instructor Image" class="rounded-circle" style="width: 25px; height: 25px;">
                        </div>
                        <div class="d-flex align-items-center">
                            <small class="font-weight-bold mr-2 text-muted">' . htmlspecialchars($instructor['instructor_fname'] . ' ' . $instructor['instructor_lname']) . '</small>
                        </div>
                    </div>
                </div>
            </a>';
        }
    }

    echo '</div></div>';

    // Button for viewing all courses
    echo '<div class="text-center m-4">
            <a class="btn btn-danger btn-sm btns" href="index.php?view_all=' . (isset($_GET['view_all']) && $_GET['view_all'] == 'true' ? 'false' : 'true') . '">' . htmlspecialchars($buttonText) . '</a>
          </div>';
}
?>

<!-- Vision, Mission, Core Values Section -->
<?php
if (!isset($_SESSION['is_login'])) {
    echo '<div class="container-fluid p-4" style="background-color:#E9ECEF; margin-top:24px;">
            <div class="container" style="background-color:#E9ECEF">
              <div class="row text-center">
                <div class="col-sm">
                  <h5>Vision</h5>
                  <p>A globally renowned University as champion of
                    sustainable societal development through
                    ethical and empowered human resources.</p>
                </div>
                <div class="col-sm">
                  <h5>Mission</h5>
                  <p>Advance knowledge generation and innovation,
                    produce globally outstanding graduates, and
                    transform communities towards inclusive progress</p>
                </div>
                <div class="col-sm">
                  <h5>Core Values</h5>
                  <p>
                    <b>N</b>ationalism
                    <br>
                    <b>E</b>xcellence
                    <br>
                    <b>U</b>nity
                    <br>
                    <b>S</b>pirituality
                    <br>
                    <b>T</b>ransparency
                  </p>
                </div>
              </div>
            </div>
          </div>';
}
?>

<?php
// Footer Include from mainInclude 
include('./mainInclude/footer.php');

?>
