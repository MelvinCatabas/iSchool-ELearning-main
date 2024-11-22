$(document).ready(function () {
  // Email Validation with Ajax
  $("#stuemail").on("keyup blur", function () {
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var stuemail = $("#stuemail").val();
    $.ajax({
      url: "Student/addstudent.php",
      type: "post",
      data: {
        checkemail: "checkmail",
        stuemail: stuemail,
      },
      success: function (data) {
        if (data != 0) {
          $("#statusMsg6").html(
            '<small style="color:red;">Email ID Already Registered!</small>'
          );
          $("#signup").attr("disabled", true);
        } else if (data == 0 && reg.test(stuemail)) {
          $("#statusMsg6").html(
            '<small style="color:green;">Email is available!</small>'
          );
          $("#signup").attr("disabled", false);
        } else if (!reg.test(stuemail)) {
          $("#statusMsg6").html(
            '<small style="color:red;">Invalid Email Format (e.g., example@mail.com)</small>'
          );
          $("#signup").attr("disabled", true);
        }
        if (stuemail.trim() == "") {
          $("#statusMsg6").html(
            '<small style="color:red;">Please Enter an Email!</small>'
          );
          $("#signup").attr("disabled", true);
        }
      },
    });
  });

  // Clear Error Message on Keypress
  $("input").on("keypress", function () {
    var fieldId = $(this).attr("id");
    $(`#statusMsg${fieldId}`).html(" ");
  });

  // Password Confirmation Validation
  $("#stupass, #stupass-confirm").on("keyup blur", function () {
    var password = $("#stupass").val();
    var confirmPassword = $("#stupass-confirm").val();
    if (password !== confirmPassword) {
      $("#statusMsg8").html(
        '<small style="color:red;">Passwords do not match!</small>'
      );
      $("#signup").attr("disabled", true);
    } else {
      $("#statusMsg8").html('<small style="color:green;">Passwords match.</small>');
      $("#signup").attr("disabled", false);
    }
  });
});

// Ajax Call for Adding New Student
// Add Student Function
function addStu() {
  const reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  const stufname = $("#stufname").val();
  const stulname = $("#stulname").val();
  const stuuser = $("#stuuser").val();
  const studob = $("#studob").val();
  const stusex = $("#stusex").val();
  const stuemail = $("#stuemail").val();
  const stupass = $("#stupass").val();

  // Validation
  if (!stufname.trim()) return showError("statusMsg1", "Please enter First Name!");
  if (!stulname.trim()) return showError("statusMsg2", "Please enter Last Name!");
  if (!stuuser.trim()) return showError("statusMsg3", "Please enter Username!");
  if (!studob.trim()) return showError("statusMsg4", "Please enter Date of Birth!");
  if (!stusex.trim()) return showError("statusMsg5", "Please select your sex!");
  if (!stuemail.trim() || !reg.test(stuemail)) return showError("statusMsg6", "Please enter a valid Email!");
  if (!stupass.trim()) return showError("statusMsg7", "Please enter Password!");

  // AJAX Submission
  $.ajax({
    url: "Student/addstudent.php",
    type: "post",
    data: {
      stusignup: "stusignup",
      stufname,
      stulname,
      stuuser,
      studob,
      stusex,
      stuemail,
      stupass,
    },
    beforeSend: function () {
      $("#signup").prop("disabled", true);
    },
    success: function (data) {
      console.log(data);
      if (data == "OK") {
        $("#successMsg").html('<span class="alert alert-success"> Registration Successful!</span>');
        clearStuRegField();
      } else {
        $("#successMsg").html('<span class="alert alert-danger"> Unable to Register!</span>');
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      alert("An error occurred while processing your request. Please try again.");
    },
    complete: function () {
      $("#signup.php").prop("disabled", false);
    },
  });
}

// Helper Function to Show Error Messages
function showError(elementId, message) {
  $(`#${elementId}`).html(`<small style="color:red;">${message}</small>`);
}

// Empty All Fields and Status Msg
function clearStuRegField() {
  $("#stuRegForm").trigger("reset");
  $("small").html(" ");
}

function clearAllStuReg() {
  $("#successMsg").html(" ");
  clearStuRegField(); 
}

// Ajax Call for Student Login Verification
function checkStuLogin() {
  var stuLogEmail = $("#stuLogEmail").val();
  var stuLogPass = $("#stuLogPass").val();
  $.ajax({
    url: "Student/addstudent.php",
    type: "post",
    data: {
      checkLogemail: "checklogmail",
      stuLogEmail: stuLogEmail,
      stuLogPass: stuLogPass,
    },
    success: function (data) {
      console.log(data);
      if (data == 0) {
        $("#statusLogMsg").html(
          '<small class="alert alert-danger"> Invalid Email ID or Password ! </small>'
        );
      } else if (data == 1) {
        $("#statusLogMsg").html(
          '<div class="spinner-border text-success" role="status"></div>'
        );
        // Empty Login Fields
        clearStuLoginField();
        setTimeout(() => {
          window.location.href = "index.php";
        }, 1000);
      }
    },
  });
}

// Empty Login Fields
function clearStuLoginField() {
  $("#stuLoginForm").trigger("reset");
}

// Ajax Call for Instructor Login Verification
function checkInstLogin() {
  var instLogEmail = $("#instLogEmail").val();
  var instLogPass = $("#instLogPass").val();
  $.ajax({
    url: "Instructor/addinst.php",
    type: "post",
    data: {
      checkLogemail: "checklogemail",
      instLogEmail: instLogEmail,
      instLogPass: instLogPass,
    },
    success: function (data) {
      console.log(data);
      if (data == 0) {
        $("#statusLogMsg").html(
          '<small class="alert alert-danger"> Invalid Email ID or Password ! </small>'
        );
      } else if (data == 1) {
        $("#statusLogMsg").html(
          '<div class="spinner-border text-success" role="status"></div>'
        );
        // Empty Login Fields
        clearInstLoginField();
        setTimeout(() => {
          window.location.href = "index.php";
        }, 1000);
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
}

// Empty Login Fields
function clearInstLoginField() {
  $("#instLoginForm").trigger("reset");
}

// Empty Login Fields and Status Msg
function clearStuLoginWithStatus() {
  $("#statusLogMsg").html(" ");
  clearStuLoginField();
}
