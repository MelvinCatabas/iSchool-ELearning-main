// Ajax Call for instructor Login Verification
function checkInstructorLogin() {
  var instructorLogEmail = $("#instructorLogEmail").val();
  var instructorLogPass = $("#instructorLogPass").val();
  $.ajax({
    url: "instructor/instructorDashboard.php",
    type: "post",
    data: {
      checkLogemail: "checklogmail",
      instructorLogEmail: instructorLogEmail,
      instructorLogPass: instructorLogPass
    },
    success: function(data) {
      console.log(data);
      if (data == 0) {
        $("#statusInstructorLogMsg").html(
          '<small class="alert alert-danger"> Invalid Email ID or Password ! </small>'
        );
      } else if (data == 1) {
        $("#statusInstructorLogMsg").html(
          '<small class="alert alert-success"> Success! Loading..... </small>'
        );
        // Empty Login Fields
        clearInstructorLoginField();
        setTimeout(() => {
          window.location.href = "instructor/instructorDashboard.php";
        }, 1000);
      }
    }
  });
}

// Empty Login Fields
function clearInstructorLoginField() {
  $("#instructorLoginForm").trigger("reset");
}

// Empty Login Fields and Status Msg
function clearInstructorLoginWithStatus() {
  $("#statusInstructorLogMsg").html(" ");
  clearInstructorLoginField();
}
