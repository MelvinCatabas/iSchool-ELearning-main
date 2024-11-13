<link rel="stylesheet" href="./css/modal.css">
<div class="d-flex align-items-center justify-content-center text-center mb-3">
  <img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="100px" />
  <!-- <span class="h1 fw-bold mb-0">NEUST</span> -->
</div>

<div class="row justify-content-center">
  <div class="col-md-7">
    <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px; font-size:24px;">Sign Up</h5>

    <form role="form" id="stuRegForm">
      <div class="form-outline mb-4">
        <label class="form-label" for="stuname">Name</label>
        <input type="text" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="ex: Dela Cruz" name="stuname" id="stuname">
      </div>

      <div class="form-outline mb-4">
        <label class="form-label" for="stuemail">Email</label>
        <input type="email" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Email" name="stuemail" id="stuemail">
      </div>

      <div class="form-outline mb-4">
        <label class="form-label" for="stupass">New Password</label>
        <input type="password" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Password" name="stupass" id="stupass">
      </div>

      <button type="button" class="btn btn-primary btn-lg btn-block" style="height:40px; font-size:16px;" id="signup" onclick="addStu()">Sign Up</button>
    </form>
  </div>
</div>

<div class="text-center mt-4">
  <a href="#!" class="small text-muted">Terms of use.</a>
  <a href="#!" class="small text-muted mx-3">Privacy policy</a>
</div>