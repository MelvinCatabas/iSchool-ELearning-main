<?php
if (!isset($_SESSION)) {
   session_start();
}
include('../dbConnection.php');

if (isset($_SESSION['is_login'])) {
   $stuEmail = $_SESSION['stuLogEmail'];
} else {
   echo "<script> location.href='../index.php'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>
      NEUST
   </title>
   <!-- Fonts and icons -->
   <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
   <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
   <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
   <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
   <link id="pagestyle" href="../css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
   <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body>

   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
         <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder mb-0">Profile Dashboard</h6>
         </nav>
         <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
         </div>
      </div>
   </nav>

   <a class="btn btn-primary" style="margin-left: 37px;" href="./myCourse.php">My Courses</a>

   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-3 border-right">
            <h4 class="text-center">Lessons</h4>
            <ul id="playlist" class="nav navbar-nav flex-column">
               <?php
               if (isset($_GET['course_id'])) {
                  $course_id = $_GET['course_id'];
                  $sql = "SELECT * FROM lesson WHERE course_id = '$course_id'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                     while ($row = $result->fetch_assoc()) {
                        echo '<li class="nav-item border-bottom py-2" movieurl="' . $row['lesson_link'] . '" style="cursor:pointer;">
                                 <span class="nav-link-text ms-1">' . $row['lesson_name'] . '</span>
                              </li>
                              <hr class="horizontal dark mt-0">';
                     }
                  }
               }
               ?>
            </ul>

            <h4 class="text-center">Activity</h4>
            <ul id="playlist" class="nav navbar-nav flex-column">
               <?php
               if (isset($_GET['course_id'])) {
                  $course_id = $_GET['course_id'];
                  $sql = "SELECT * FROM activity WHERE course_id = '$course_id'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                     while ($row = $result->fetch_assoc()) {
                        echo '<li class="nav-item border-bottom py-2">
                                 <a href="' . $row['activity_link'] . '" target="_blank" style="text-decoration: none;" class="d-flex align-items-center">
                                    <span class="nav-link-text ms-1">' . $row['activity_title'] . '</span>
                                 </a>
                              </li>
                              <hr class="horizontal dark mt-0">';
                     }
                  }
               }
               ?>
            </ul>


         </div>
         <div class="col-sm-8">
         <iframe width="681" height="383" src="https://youtube.com/embed/rfCrPS4MrDc" title="PALAGI - TJxKZ | LIVE SESSIONS" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
         </div>
      </div>
   </div>

   <!-- <div class="container-fluid">
      <div class="row">
         <div class="col-sm-3 border-right">
           
         </div>
      </div>
   </div> -->

   <!-- Scripts -->
   <script type="text/javascript" src="../js/jquery.min.js"></script>
   <script type="text/javascript" src="../js/popper.min.js"></script>
   <script type="text/javascript" src="../js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../js/all.min.js"></script>
   <script type="text/javascript" src="../js/custom.js"></script>
</body>

</html>
