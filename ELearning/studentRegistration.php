<link rel="stylesheet" href="./css/modal.css">
<div class="d-flex align-items-center justify-content-center text-center mb-3">
  <img src="https://neust.edu.ph/wp-content/uploads/2020/06/neust_logo-1.png" width="100px" />
</div>

<div class="row justify-content-center">
  <div class="col-md-12">
    <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px; font-size:24px;">Sign Up</h5>

    <form role="form" id="stuRegForm">
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
          <div class="form-outline mb-4">
            <label class="form-label" for="stufname">First Name</label>
            <input type="text" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="First Name" name="stufname" id="stufname">
          </div>

          <div class="form-outline mb-4">
            <label class="form-label" for="stuuser">Username</label>
            <input type="text" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Username" name="stuuser" id="stuuser">
          </div>

          <div class="form-outline mb-4">
            <label class="form-label" for="studob">Date of Birth</label>
            <input type="date" class="form-control form-control-lg" style="height:40px; font-size:16px;" name="studob" id="studob">
          </div>

          <div class="form-outline mb-4">
            <label class="form-label" for="stupass">Password</label>
            <input type="password" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Password" name="stupass" id="stupass">
          </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
          <div class="form-outline mb-4">
            <label class="form-label" for="stulname">Last Name</label>
            <input type="text" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Last Name" name="stulname" id="stulname">
          </div>

          <div class="form-outline mb-4">
            <label class="form-label" for="stuemail">Email</label>
            <input type="email" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Email" name="stuemail" id="stuemail">
          </div>

          <div class="form-outline mb-4">
            <label class="form-label" for="stusex">Sex</label>
            <select class="form-control form-control-lg" style="height:40px; font-size:16px;" name="stusex" id="stusex">
              <option value="" disabled selected>Select your sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="form-outline mb-4">
            <label class="form-label" for="stupass-confirm">Confirm Password</label>
            <input type="password" class="form-control form-control-lg" style="height:40px; font-size:16px;" placeholder="Confirm Password" name="stupass-confirm" id="stupass-confirm">
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-primary btn-lg btn-block" style="height:40px; font-size:16px;" id="signup">Sign Up</button>
    </form>
  </div>
</div>

<div class="text-center mt-4">
  <a href="#!" class="small text-muted">Terms of use.</a>
  <a href="#!" class="small text-muted mx-3">Privacy policy</a>
</div>

<script>
  document.getElementById("signup").addEventListener("click", function () {
    const password = document.getElementById("stupass").value;
    const confirmPassword = document.getElementById("stupass-confirm").value;

    if (password !== confirmPassword) {
      alert("Passwords do not match. Please try again.");
    } else {

      Swal.fire({
                title: "Success!",
                text: "You have successfully Sign in.",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
            }).then(function() {
                Swal.close();
            });

      addStu();
    }
  });
</script>
