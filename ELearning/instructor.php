<?php
include('./config.php');
include('./dbConnection.php');

// Header Include from mainInclude 
include('./mainInclude/headerinst.php');
?>

<link rel="stylesheet" href="./css/style.css">
<!-- Start Video Background-->
<div class="container-fluid remove-vid-marg">
  <div class="vid-parent">
    <video playsinline autoplay muted loop>
      <source src="video/neust.mp4" />
    </video>
    <div class="vid-overlay"></div>
  </div>
  <div class="vid-content">
    <h1 class="my-content">Welcome to <b>NEUST</b></h1>
    <small class="my-content">Learn and Implement</small><br />
    <?php
    if (!isset($_SESSION['is_login'])) {
      echo '<a class="btn btns mt-3" href="#" data-toggle="modal" data-target="#instLoginModalCenter">Login</a>';
    } else {
      echo '<a class="btn btn-primary mt-3" href="instructor/instProfile.php">My Profile</a>';
    }
    ?>

  </div>
</div>


<?php
if (!isset($_SESSION['is_login'])) {
} else {
  echo '<div class="container mt-5"> 
    <h1 class="text-center">Popular Course</h1>
    <div class="card-deck mt-4">';

  $sql = "SELECT * FROM course LIMIT 3";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $course_id = $row['course_id'];
      echo '
            <a href="coursedetails.php?course_id=' . $course_id . '" class="btn" style="text-align: left; padding:0px; margin:0px;">
              <div class="card cour">
                <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Guitar" />
                <div class="card-body">
                  <h5 class="card-title">' . $row['course_name'] . '</h5>
                  <p class="card-text">' . $row['course_desc'] . '</p>
                </div>
                <div class="card-footer">
                  <p class="card-text d-inline">Price: <small><del>&#8377 ' . $row['course_original_price'] . '</del></small> <span class="font-weight-bolder">&#8377 ' . $row['course_price'] . '<span></p> <a class="btn btn-primary text-white font-weight-bolder float-right" href="coursedetails.php?course_id=' . $course_id . '">Open</a>
                </div>
              </div>
            </a>';
    }
  }

  echo '</div>';
  echo '<div class="card-deck mt-4">';

  $sql = "SELECT * FROM course LIMIT 3,3";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $course_id = $row['course_id'];
      echo '
                        <a href="coursedetails.php?course_id=' . $course_id . '"  class="btn" style="text-align: left; padding:0px;">
                          <div class="card">
                            <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Guitar" />
                            <div class="card-body">
                              <h5 class="card-title">' . $row['course_name'] . '</h5>
                              <p class="card-text">' . $row['course_desc'] . '</p>
                            </div>
                            <div class="card-footer">
                              <p class="card-text d-inline">Price: <small><del>&#8377 ' . $row['course_original_price'] . '</del></small> <span class="font-weight-bolder">&#8377 ' . $row['course_price'] . '<span></p> <a class="btn btn-primary text-white font-weight-bolder float-right" href="#">Enroll</a>
                            </div>
                          </div>
                        </a>  ';
    }
  }

  echo '</div>';

  echo ' <div class="text-center m-4">
          <a class="btn btn-danger btn-sm btns" href="courses.php">View All Course</a>
        </div>
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