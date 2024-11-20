<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Dashboard');
define('PAGE', 'dashboard');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];

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
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
$totalcourse = $result->num_rows;

 $sql = "SELECT * FROM student";
 $result = $conn->query($sql);
 $totalstu = $result->num_rows;

 $sql = "SELECT * FROM lesson";
 $result = $conn->query($sql);
 $totallesson = $result->num_rows;

 $sql = "SELECT * FROM activity";
 $result = $conn->query($sql);
 $totalact = $result->num_rows;


?>
  <div class="col-sm-9 mt-5">


  <div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                        <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                        <?php echo $totalcourse; ?>
                                    </h5>
                                    <span class="text-white text-sm">Courses</span>
                                </div>
                                <div class="col-4">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
                    <div class="card">
                        <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                        <i class="ni ni-active-40 text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                        <?php echo $totalstu; ?>
                                    </h5>
                                    <span class="text-white text-sm">Students</span>
                                </div>
                                <div class="col-4">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                        <i class="ni ni-cart text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $totallesson; ?>
                                    </h5>
                                    <span class="text-white text-sm">Lesson</span>
                                </div>
                                <div class="col-4">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
                    <div class="card">
                        <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                        <i class="ni ni-like-2 text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                    <?php echo $totalact; ?>
                                    </h5>
                                    <span class="text-white text-sm">Activity</span>
                                </div>
                                <div class="col-4">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  -->
        <!--  -->

        <div class="col-lg-6 col-12 mt-4 mt-lg-0">
            <div class="card shadow h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Reviews</h6>
                </div>
                <div class="card-body pb-0 p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-0">
                            <div class="w-100">
                                <div class="d-flex mb-2">
                                    <span class="me-2 text-sm font-weight-bold text-dark">Student</span>
                                    <span class="ms-auto text-sm font-weight-bold"><?php echo $totalstu; ?>%</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-primary w-<?php echo $totalstu; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex mb-2">
                                    <span class="me-2 text-sm font-weight-bold text-dark">Course</span>
                                    <span class="ms-auto text-sm font-weight-bold"> <?php echo $totalcourse; ?>%</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-primary w-<?php echo $totalcourse; ?>" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex mb-2">
                                    <span class="me-2 text-sm font-weight-bold text-dark">Lesson</span>
                                    <span class="ms-auto text-sm font-weight-bold"> <?php echo $totallesson; ?>%</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-primary w-<?php echo $totallesson; ?>" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex mb-2">
                                    <span class="me-2 text-sm font-weight-bold text-dark">Activity</span>
                                    <span class="ms-auto text-sm font-weight-bold"><?php echo $totalact; ?>%</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-primary w-<?php echo $totalact; ?>  " role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer pt-0 p-3 d-flex align-items-center">
                    <!-- <div class="w-60">
                        <p class="text-sm">
                            More than <b>1,500,000</b> developers used Creative Tim's products and over <b>700,000</b> projects were created.
                        </p>
                    </div>
                    <div class="w-40 text-end">
                        <a class="btn btn-dark mb-0 text-end" href="javascript:;">View all reviews</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4" style="width:1000px;">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">

                        <div class="col-lg-6 col-5 my-auto text-end">

                        </div>
                    </div>
                </div>



                <!--  -->
                <!--  -->


                <?php
                $sql = "SELECT * FROM enrollees";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<h6 class="mx-3 pt-3">Enrolles</h6>
                    <div class="card-body px-0 pb-2">
                    
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Course ID</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Enrollment Date</th>
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
                            <h6 class="mb-0 text-sm">' . $row["course_id"] . '</h6>
                          </div>
                        </div>
                      </td>';


                        echo '<td>' . $row["stu_id"] . '</td>';


                        echo '<td class="align-middle text-center text-sm">
                       ' . $row["enrolment_date"] . '
                      </td>';

                        echo '</tr>';
                    }

                    echo '</table>
                  </div>
                </div>
              </div>
            </div>';
                } else {
                    echo "0 Result";
                }






                ?>



                  <!--  -->
        <!--  -->



      
    </div>
  </main>






                <!--   Core JS Files   -->
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










  </div>
  </div>
  </div>
  
  </div>  <!-- div Row close from header -->
 </div>  <!-- div Conatiner-fluid close from header -->
<?php
include('./adminInclude/footer.php'); 
?>