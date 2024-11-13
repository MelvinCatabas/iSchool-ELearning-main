<?php
include('./config.php');
include('./dbConnection.php');

// Header Include from mainInclude 
include('./mainInclude/header.php');
?>

<link rel="stylesheet" href="./css/style.css">
<!-- Start Video Background-->
    <?php
    if (!isset($_SESSION['is_login'])) {
      echo '<div class="container-fluid remove-vid-marg">
  <div class="vid-parent">
    <video playsinline autoplay muted loop>
      <source src="video/neust.mp4" />
    </video>
    <div class="vid-overlay"></div>
  </div>
  <div class="vid-content">
    <h1 class="my-content">Welcome to <b>NEUST</b></h1>
    <small class="my-content">Learn and Implement</small><br />';
      echo '<a class="btn btns mt-3" href="#" data-toggle="modal" data-target="#stuRegModalCenter">Get Started</a>';
    } else {
      // echo '<a class="btn btn-primary mt-3" href="student/studentProfile.php">My Profile</a>';
    }

    ?>

  </div>
</div>


<?php
// Check if the user is logged in
if (!isset($_SESSION['is_login'])) {
  // If not logged in, you can add code here if needed, or leave it empty.
} else {
  // Check if 'view_all' is set in the URL (from clicking "View All")
  if (isset($_GET['view_all']) && $_GET['view_all'] == 'true') {
    // If 'view_all' is true, remove the limit and show all courses
    $sql = "SELECT * FROM course";
    $buttonText = "Limit View";
  } else {
    // Default query with limit 4 for first-time page load
    $sql = "SELECT * FROM course LIMIT 4";
    $buttonText = "View All Course";
  }

  // Execute the SQL query
  $result = $conn->query($sql);

  echo '<div class="container-fluid py-5 my-5">
          <div class="row">';

  if ($result->num_rows > 0) {
    // Loop through the results and display courses
    while ($row = $result->fetch_assoc()) {
      $course_id = $row['course_id'];
      echo '
      <!-- Card -->
      <a href="coursedetails.php?course_id=' . $course_id . '" class="col-md-3 mb-3">
        <div class="card" style="height:400px">
          <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Course Image"/>
          <div class="card-body">
            <h5 class="card-title">' . $row['course_name'] . '</h5>
            <p class="card-text">' . $row['course_desc'] . '</p>
          </div>
          <div class="card-footer d-flex align-items-center justify-content-between">
            <div>
              <img src="' . str_replace('..', '.', $row['course_img']) . '" alt="Instructor Image" class="rounded-circle" style="width: 25px; height: 25px;">
            </div>
            <div class="d-flex align-items-center">
              <small class="font-weight-bold mr-2 text-muted">' . $row['course_name'] . '</small>
            </div>
          </div>
        </div>
      </a>';
    }
  }

  echo '</div>
        </div>';

  // Add a button to view all courses, passing 'view_all=true' in the URL
  echo '<div class="text-center m-4">
          <a class="btn btn-danger btn-sm btns" href="index.php?view_all=' . (isset($_GET['view_all']) && $_GET['view_all'] == 'true' ? 'false' : 'true') . '">' . $buttonText . '</a>
        </div>';
}
?>













<!-- End Most Popular Course -->

<!-- Start Students Testimonial -->
<!-- <div class="container-fluid mt-5" style="background-color: #4B7289" id="Feedback">
  <h1 class="text-center testyheading p-4"> Student's Feedback </h1>
  <div class="row">
    <div class="col-md-12">
      <div id="testimonial-slider" class="owl-carousel">
        <?php
        $sql = "SELECT s.stu_name, s.stu_occ, s.stu_img, f.f_content FROM student AS s JOIN feedback AS f ON s.stu_id = f.stu_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $s_img = $row['stu_img'];
            $n_img = str_replace('../', '', $s_img)
        ?>
            <div class="testimonial">
              <p class="description con">
                <?php echo $row['f_content']; ?>
              </p>
              <div class="pic">
                <img src="<?php echo $n_img; ?>" alt="" />
              </div>
              <div class="testimonial-prof">
                <h4><?php echo $row['stu_name']; ?></h4>
                <small><?php echo $row['stu_occ']; ?></small>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </div>
</div>  -->
<!-- End Students Testimonial -->


<!-- Start About Section -->
<div class="container-fluid p-4" style="background-color:#E9ECEF; margin-top:24px;">
  <div class="container" style="background-color:#E9ECEF">
    <div class="row text-center">
      <div class="col-sm">
        <h5>Vison</h5>
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
          <b>E </b>xcellence
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
</div> <!-- End About Section -->

<?php
// Footer Include from mainInclude 
include('./mainInclude/footer.php');

?>

