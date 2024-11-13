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
    <title>NEUST</title>
</head>
<body>
 
    <style>
        .navbar{
          background-color: transparent;
        }
    
        .navbar-nav .nav-link {
            color: #ffffff !important; 
        }
        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar-brand:hover{
            color: #ffffff;
        }
        
        .navbar-toggler-icon{
          color: #ffffff;
        }        

        .bt{
            width: 82px;
            padding: 8px;
            background-color: #f8961f;
            border-radius: 8px;
            margin-right: 8px;
            text-align: center;
        }

        .bx{
            width: 82px;
            padding: 8px;
            background-color: #1f4966;
            border-radius: 8px;
            text-align: center;
        }

        .bc{
            width: 82px;
            padding: 8px;
            background-color: #343a40;
            border-radius: 8px;
            margin-right: 8px;
            text-align: center;
        }
    </style>

    <!-- Start Navigation -->
    <nav class="navbar navbar-expand-md fixed-top">
        <a href="index.php" class="navbar-brand"><img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="70px" />    NEUST</a>
        <!-- <span class="navbar-text" style="color: #ffffff;">Learn and Implement</span> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myMenu" aria-controls="myMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">=</span>
        </button>
        
        <div class="collapse navbar-collapse" id="myMenu">
            <ul class="navbar-nav ml-auto">
                <?php 
                    session_start();   
                    if (isset($_SESSION['is_login'])){
                        echo '<li class="nav-item"><a href="student/studentProfile.php" class="nav-link">My Profile</a></li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>';
                    } else {
                        echo '<li class="nav-item"><a href="#login" class="bt nav-link" data-toggle="modal" data-target="#stuLoginModalCenter">Login</a></li>';
                        echo '<li class="nav-item"><a href="#signup" class="bx nav-link" data-toggle="modal" data-target="#stuRegModalCenter">Signup</a></li>';     
                    }
                ?> 
            </ul>
        </div>
    </nav>
    <!-- End Navigation -->

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
