<?php
  include('./dbConnection.php');
  // Header Include from mainInclude 
  include('./mainInclude/header.php'); 
?>  
    <div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
      <div class="row">
        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhGtlfMHr3H3zVcof-QKUTs1p-mugN_Y9pmFOLw_Gv7EqrLRFMzSPcTYboJglezLLTuNjzftYKxKRp6f57ifHcQObyd0f2cZtTepXDI-QzItYB5dS9sBM4HwjUg0qGPvyL4AqMj7O-tBOAq/w1200-h630-p-k-no-nu/1549285206999.jpg" alt="courses" style="height:200px; width:100%; object-fit:cover; box-shadow:10px;"/>
      </div> 
    </div> <!-- End Course Page Banner -->

    <div class="container mt-5"> <!-- Start All Course -->
      <?php
          if(isset($_GET['course_id'])){
           $course_id = $_GET['course_id'];
           $_SESSION['course_id'] = $course_id;
           $sql = "SELECT * FROM course WHERE course_id = '$course_id'";
          $result = $conn->query($sql);
          if($result->num_rows > 0){ 
            while($row = $result->fetch_assoc()){
              echo ' 
                <div class="row">
                <div class="col-md-4">
                  <img src="'.str_replace('..', '.', $row['course_img']).'" class="card-img-top" alt="Guitar" />

                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">Course Name: '.$row['course_name'].'</h5>
                    <p class="card-text"> Description: '.$row['course_desc'].'</p>
                    <p class="card-text"> Duration: '.$row['course_duration'].'</p>
                    <form action="checkout.php" method="post">
              
                      <button type="submit" class="btn btn-primary text-white font-weight-bolder float-right" name="buy">Buy Now</button>
                    </form>
                  </div>
                </div>
              ';
            }
          }
         }
        ?>   
      </div><!-- End All Course --> 
      <div class="container">
          <div class="row">
          <?php $sql = "SELECT * FROM lesson";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
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
             while($row = $result->fetch_assoc()){
              if($row['course_id'] == $course_id) {
               $num++;
              echo ' <tr>
               <th scope="row">'.$num.'</th>
               <td style="border: none">'. $row["lesson_name"].'  </td>
               <td style="border: none"><b>:</b></td></tr>';
          
              }
             }
             
             echo '</tbody>
           </table>';
            } ?>         
       </div>
      </div>  
     <?php 
  // Footer Include from mainInclude 
  include('./mainInclude/footer.php'); 
?>  
