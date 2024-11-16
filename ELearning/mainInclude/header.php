<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link id="pagestyle" href="../css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <title>NEUST</title>
</head>

<body>

    <style>
        .navbars {
            background: rgba(255, 255, 255, 0.15);
            /* box-shadow: 0 8px 7px 0 rgb(255,255,255); */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(6.5px);
            /* border-radius: 10px; */
            border: 1px solid rgba(255, 255, 255, 0.18);
            height: 90px;

        }
        

        /* .navbar-nav .nav-link {
            color: #ffffff; 
        } */

        .navbar-nav .nav-link:hover {
            color: #e9ecef;
        }

        .l {
            color: #1d3698;
        }


        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar-brand:hover {
            color: #ffffff;
        }

        .navbar-toggler-icon {
            color: #ffffff;
        }

        .bt {
            color: #ffffff;
            width: 82px;
            padding: 8px;
            background-color: #f8961f;
            border-radius: 8px;
            margin-right: 8px;
            text-align: center;
        }

        .bx {
            color: #ffffff;
            width: 82px;
            padding: 8px;
            background-color: #1f4966;
            border-radius: 8px;
            text-align: center;
        }

        .bc {
            color: #ffffff;
            width: 82px;
            padding: 8px;
            background-color: #343a40;
            border-radius: 8px;
            margin-right: 8px;
            text-align: center;
        }
    </style>

    <!-- Start Navigation -->
    <nav class=" navbars navbar-expand fixed-top">

        <?php
        session_start();
        if (isset($_SESSION['is_login'])) {
            echo '<a href="index.php" class="navbar-brand pl-2"><img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="70px" />    <span style="color:#1d3698;">NEUST</span></a>
                        <!-- <span class="navbar-text" style="color: #ffffff;">Learn and Implement</span> -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myMenu" aria-controls="myMenu" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon" style="color:#1d3698;">=</span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="myMenu">
                            <ul class="navbar-nav ml-auto">';

            echo '<li class="nav-item" style="position:relative; bottom:60px;"><a href="student/studentProfile.php" class="nav-link l">My Profile</a></li>';
            echo '<li class="nav-item pr-2" style="position:relative; bottom:60px;"><a href="logout.php" class="nav-link l">Logout</a></li>';
        } else {

            echo '<a href="index.php" class="navbar-brand"><img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="70px" />  NEUST</a>
                        <!-- <span class="navbar-text" style="color: #ffffff;">Learn and Implement</span> -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myMenu" aria-controls="myMenu" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">=</span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="myMenu">
                            <ul class="navbar-nav ml-auto">';

            echo '<li class="nav-item" style="position:relative; bottom:60px;"><a href="#login" class="bt nav-link" data-toggle="modal" data-target="#stuLoginModalCenter">Login</a></li>';
            echo '<li class="nav-item pr-2" style="position:relative; bottom:60px;"><a href="#signup" class="bx nav-link" data-toggle="modal" data-target="#stuRegModalCenter">Signup</a></li>';
        }
        ?>
        </ul>
        </div>
    </nav>
    <!-- End Navigation -->


    <!-- Include Bootstrap JS and jQuery -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>