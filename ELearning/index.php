<?php

// include('./config.php');
include('./dbConnection.php');

include('./mainInclude/header.php');
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
              <div class="vid-content pl-4">
                <h1 class="my-content">Welcome to <b>NEUST</b></h1>
                <small class="my-content" Style="font-size:16px;">Learn and Implement</small><br />';
    if (!isset($_SESSION['is_login'])) {

        echo '<a class="btn btns mt-3" href="#" data-toggle="modal" data-target="#stuRegModalCenter">Get Started</a>';
    }
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
        $buttonText = "View All Course";
    }

    $result = $conn->query($sql);

    if (!isset($_SESSION['alert_shown'])) {
        echo '<script>
            Swal.fire({
                title: "Success!",
                text: "You have successfully logged in.",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
            }).then(function() {
                Swal.close();
            });
        </script>';

        
        $_SESSION['alert_shown'] = true;
    }

    echo '<div class="container-fluid py-5 my-5">';

    echo '<div class="row mt-4 mb-5">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">NEUST E-Learning</p>
                <h5 class="font-weight-bolder">E Learning</h5>
                <p class="mb-5">From colors, cards, typography to complex elements, you will find the full documentation.</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="https://neust.edu.ph/" target="_blank">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
              <div class="border-radius-lg h-100" style="background-color:#252525; border-radius: 10px;">
        
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
               
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';

    echo '<div class="col-lg-5 mb-5">
          <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-color: #252525; border-radius: 10px;">
              <span class="mask bg-gradient-dark"></span>
              <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                <h5 class="text-white font-weight-bolder mb-4 pt-2">Work with the rockets</h5>
                <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p>
                <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="blog.html" target="_blank">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div> ';

    
      echo ' <div class="row">';

            

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $course_id = $row['course_id'];
            $instructor_id = $row['instructor_id'];


            // Fetch instructor details
            $instructor_sql = "SELECT * FROM instructor WHERE instructor_id = '$instructor_id'";
            $instructor_result = $conn->query($instructor_sql);
            $instructor = $instructor_result->fetch_assoc();

            echo '
            <!-- Course Card -->
            <a style="text-decoration:none;" href="coursedetails.php?course_id=' . $course_id . '" class="col-md-3 mb-3">
                <div class="card" style="height:400px">
                    <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Course Image"/>
                    <div class="card-body">
                        <h5 class="card-title" style="color: #252525; font-weight:bold;">' . $row['course_name'] . '</h5>
                        <p class="card-text" style="color: #252525;">' . $row['course_desc'] . '</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div>
                            <img src="' . str_replace('..', '.', $instructor['instructor_img']) . '" alt="Instructor Image" class="rounded-circle" style="width: 25px; height: 25px;">
                        </div>
                        <div class="d-flex align-items-center">
                            <small class="font-weight-bold mr-2 text-muted">' . $instructor['instructor_fname'] . ' ' . $instructor['instructor_lname'] . '</small>
                        </div>
                    </div>
                </div>
            </a>';
        }
    }

    echo '</div></div>';

    // Button for viewing all courses
    echo '<div class="text-center m-4">
            <a class="btn btn-sm btns" href="index.php?view_all=' . (isset($_GET['view_all']) && $_GET['view_all'] == 'true' ? 'false' : 'true') . '">' . $buttonText . '</a>
          </div>';
}
?>

<?php

if (!isset($_SESSION['is_login'])) {



    echo '<div class="container-fluid p-4" style="background-color:#E9ECEF; margin-top:24px;">
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
  </div> ';
}
?>




<script src="../js/popper.min.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/perfect-scrollbar.min.js"></script>
                <script src="../js/smooth-scrollbar.min.js"></script>
                <script src="../js/chartjs.min.js"></script>
                <script>
                    var ctx = document.getElementById("chart-bars").getContext("2d");

                    new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                label: "Sales",
                                tension: 0.4,
                                borderWidth: 0,
                                borderRadius: 4,
                                borderSkipped: false,
                                backgroundColor: "#fff",
                                data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                                maxBarThickness: 6
                            }, ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                            scales: {
                                y: {
                                    grid: {
                                        drawBorder: false,
                                        display: false,
                                        drawOnChartArea: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        suggestedMax: 500,
                                        beginAtZero: true,
                                        padding: 15,
                                        font: {
                                            size: 14,
                                            family: "Inter",
                                            style: 'normal',
                                            lineHeight: 2
                                        },
                                        color: "#fff"
                                    },
                                },
                                x: {
                                    grid: {
                                        drawBorder: false,
                                        display: false,
                                        drawOnChartArea: false,
                                        drawTicks: false
                                    },
                                    ticks: {
                                        display: false
                                    },
                                },
                            },
                        },
                    });


                    var ctx2 = document.getElementById("chart-line").getContext("2d");

                    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

                    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
                    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

                    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

                    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
                    gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                    gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

                    new Chart(ctx2, {
                        type: "line",
                        data: {
                            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                    label: "Mobile apps",
                                    tension: 0.4,
                                    borderWidth: 0,
                                    pointRadius: 0,
                                    borderColor: "#cb0c9f",
                                    borderWidth: 3,
                                    backgroundColor: gradientStroke1,
                                    fill: true,
                                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                                    maxBarThickness: 6

                                },
                                {
                                    label: "Websites",
                                    tension: 0.4,
                                    borderWidth: 0,
                                    pointRadius: 0,
                                    borderColor: "#3A416F",
                                    borderWidth: 3,
                                    backgroundColor: gradientStroke2,
                                    fill: true,
                                    data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
                                    maxBarThickness: 6
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                            scales: {
                                y: {
                                    grid: {
                                        drawBorder: false,
                                        display: true,
                                        drawOnChartArea: true,
                                        drawTicks: false,
                                        borderDash: [5, 5]
                                    },
                                    ticks: {
                                        display: true,
                                        padding: 10,
                                        color: '#b2b9bf',
                                        font: {
                                            size: 11,
                                            family: "Inter",
                                            style: 'normal',
                                            lineHeight: 2
                                        },
                                    }
                                },
                                x: {
                                    grid: {
                                        drawBorder: false,
                                        display: false,
                                        drawOnChartArea: false,
                                        drawTicks: false,
                                        borderDash: [5, 5]
                                    },
                                    ticks: {
                                        display: true,
                                        color: '#b2b9bf',
                                        padding: 20,
                                        font: {
                                            size: 11,
                                            family: "Inter",
                                            style: 'normal',
                                            lineHeight: 2
                                        },
                                    }
                                },
                            },
                        },
                    });
                </script>
                <script>
                    var win = navigator.platform.indexOf('Win') > -1;
                    if (win && document.querySelector('#sidenav-scrollbar')) {
                        var options = {
                            damping: '0.5'
                        }
                        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                    }
                </script>
                <!-- Github buttons -->
                <script async defer src="https://buttons.github.io/buttons.js"></script>
                <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
                <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>





<?php
include('./mainInclude/footer.php');
?>