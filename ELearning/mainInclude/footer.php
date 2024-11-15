 <!-- Start Footer -->
 <footer class="container-fluid bg-dark text-center p-2">
   <small class="text-white"> &copy; || Group ||
     <?php
      if (isset($_SESSION['is_admin_login'])) {
        echo '<a href="admin/adminDashboard.php"> Admin Dashboard</a> <a href="logout.php">Logout</a>';
      } else {
        echo '<a href="#login" data-toggle="modal" data-target="#adminLoginModalCenter"> Admin Login</a>';
      }
      ?>
   </small>

 </footer> <!-- End Footer -->

 <!-- Start Student Registration Modal -->
 <div class="modal fade" id="stuRegModalCenter" tabindex="-1" role="dialog" aria-labelledby="stuRegModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header" style="border:none;">
         <!-- <h5 class="modal-title" id="stuRegModalCenterTitle">Student Registration</h5> -->
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearAllStuReg()">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body p4">
         <!--Start Form Registration-->
         <?php include('studentRegistration.php'); ?>
         <!-- End Form Registration -->
       </div>
       <!-- <div class="modal-footer">
            <span id="successMsg"></span>
            <button type="button" class="btn btn-primary" id="signup" onclick="addStu()">Sign Up</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearAllStuReg()">Close</button>
          </div> -->
     </div>
   </div>
 </div> <!-- End Student Registration Modal -->


 <!-- Start Student Login Modal -->
 <div class="modal fade" id="stuLoginModalCenter" tabindex="-1" role="dialog" aria-labelledby="stuLoginModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header" style="border:none;">
         <!-- <h5 class="modal-title" id="stuLoginModalCenterTitle">Student Login</h5> -->
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="clearStuLoginWithStatus()">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <!-- <form role="form" id="stuLoginForm">
              <div class="form-group">
                <i class="fas fa-envelope"></i><label for="stuLogEmail" class="pl-2 font-weight-bold">Email</label><small id="statusLogMsg1"></small><input type="email"
                    class="form-control" placeholder="Email" name="stuLogEmail" id="stuLogEmail">
                </div>
                <div class="form-group">
                  <i class="fas fa-key"></i><label for="stuLogPass" class="pl-2 font-weight-bold">Password</label><input type="password" class="form-control" placeholder="Password" name="stuLogPass" id="stuLogPass">
              </div>
            </form> -->

         <link rel="stylesheet" href="./css/modal.css">
         <div class="d-flex align-items-center justify-content-center text-center mb-3">
           <img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="100px" />
           <!-- <span class="h1 fw-bold mb-0">NEUST</span> -->
         </div>

         <div class="row justify-content-center">
           <div class="col-md-7">

             <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px; font-size:24px;">Sign into your account</h5>

             <form role="form" id="stuRegForm">
               <div class="form-outline mb-4">
                 <label class="form-label" for="stuLogEmail">Email Address</label>
                 <input type="text" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="ex: Dela Cruz" name="stuLogEmail" id="stuLogEmail">
               </div>

               <div class="form-outline mb-4">
                 <label class="form-label" for="stuLogPass">Password</label>
                 <input type="password" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Password" name="stuLogPass" id="stuLogPass">

               </div>

               <button type="button" class="btn btn-primary btn-lg btn-block" style="height:40px; font-size:16px;" id="stuLoginBtn" onclick="checkStuLogin()">Login</button>

               <small id="statusLogMsg" class="row justify-content-center mt-3"></small>
             </form>
           </div>
         </div>

         <div class="text-center mt-4">
           <a href="#!" class="small text-muted">Terms of use.</a>
           <a href="#!" class="small text-muted mx-3">Privacy policy</a>
         </div>


       </div>
       <!-- <div class="modal-footer">
            <small id="statusLogMsg"></small>
            <button type="button" class="btn btn-primary" id="stuLoginBtn" onclick="checkStuLogin()">Login</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="clearStuLoginWithStatus()">Cancel</button>
          </div> -->
     </div>
   </div>
 </div> <!-- End Student Login Modal -->

 <!-- Start Instructor Login Modal -->
 <div class="modal fade" id="instLoginModalCenter" tabindex="-1" role="dialog" aria-labelledby="instLoginModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header" style="border:none;">
        
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
  

         <link rel="stylesheet" href="./css/modal.css">
         <div class="d-flex align-items-center justify-content-center text-center mb-3">
           <img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="100px" />

         </div>

         <div class="row justify-content-center">
           <div class="col-md-7">
             <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px; font-size:24px;">Instructor</h5>


             <form role="form" id="stuRegForm">
               <div class="form-outline mb-4">
                 <label class="form-label" for="stuLogEmail">Email Provide</label>
                 <input type="text" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Instructor" name="instLogEmail" id="instLogEmail">
               </div>

               <div class="form-outline mb-4">
                 <label class="form-label" for="stuLogPass">Password</label>
                 <input type="password" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Password" name="instLogPass" id="instLogPass">

               </div>

               <button type="button" class="btn btn-primary btn-lg btn-block" style="height:40px; font-size:16px;" id="instLoginBtn" onclick="checkInstLogin()">Login</button>

               <small id="statusLogMsg" class="row justify-content-center mt-3"></small>
             </form>
           </div>
         </div>

         <div class="text-center mt-4">
           <a href="#!" class="small text-muted">Terms of use.</a>
           <a href="#!" class="small text-muted mx-3">Privacy policy</a>
         </div>


       </div>
 
     </div>
   </div>
 </div>


 <!-- Start Admin Login Modal -->
 <div class="modal fade" id="adminLoginModalCenter" tabindex="-1" role="dialog" aria-labelledby="adminLoginModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="adminLoginModalCenterTitle">Admin Login</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="clearAdminLoginWithStatus()">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <form role="form" id="adminLoginForm">
           <div class="form-group">
             <i class="fas fa-envelope"></i><label for="adminLogEmail" class="pl-2 font-weight-bold">Email</label><input type="email"
               class="form-control" placeholder="Email" name="adminLogEmail" id="adminLogEmail">
           </div>
           <div class="form-group">
             <i class="fas fa-key"></i><label for="adminLogPass" class="pl-2 font-weight-bold">Password</label><input type="password" class="form-control" placeholder="Password" name="adminLogPass" id="adminLogPass">
           </div>
         </form>
       </div>
       <div class="modal-footer">
         <small id="statusAdminLogMsg"></small>
         <button type="button" class="btn btn-primary" id="adminLoginBtn" onclick="checkAdminLogin()">Login</button>
         <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="clearAdminLoginWithStatus()">Cancel</button>
       </div>
     </div>
   </div>
 </div> <!-- End Admin Login Modal -->

 <!-- Jquery and Boostrap JavaScript -->
 <script type="text/javascript" src="js/jquery.min.js"></script>
 <script type="text/javascript" src="js/popper.min.js"></script>
 <script type="text/javascript" src="js/bootstrap.min.js"></script>

 <!-- Font Awesome JS -->
 <script type="text/javascript" src="js/all.min.js"></script>

 <!-- Student Testimonial Owl Slider JS  -->
 <script type="text/javascript" src="js/owl.min.js"></script>
 <script type="text/javascript" src="js/testyslider.js"></script>

 <!-- Student Ajax Call JavaScript -->
 <script type="text/javascript" src="js/ajaxrequest.js"></script>

 <!-- Admin Ajax Call JavaScript -->
 <script type="text/javascript" src="js/adminajaxrequest.js"></script>

 <!-- Custom JavaScript -->
 <script type="text/javascript" src="js/custom.js"></script>
 </body>

 </html>