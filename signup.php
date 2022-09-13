<?php
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

if (isset($_SESSION["user_email"])) {
  header("Location: home.php");
  die();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up - Class Connect: List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link href="css/custom.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="container col-xl-10 col-xxl-10 px-4 py-5">
    <div class="row align-items-center align-self-center g-lg-5 py-5 w-100">
      <div class="col-lg-7 text-center text-lg-start w-10">
        <h1 class="display-4 fw-bold lh-1 mb-3">Sign-up</h1>
        <p class="col-lg-10 fs-2">Create an account to manage your <newLine>to-dos.</newLine>
        </p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" id="registerForm">
          <div class="form-floating mb-3">
            <input type="email" name="register_email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary">Continue</button>
          <small class="text-muted">
            <br></br>By clicking "Continue", you agree to the terms of use.
          </small>
          <hr class="my-4">
          <button class="w-100 btn btn-outline-success" onClick="location.href='index.php'">Already have an account?</button>

        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

  <!--JQUERY CDN-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>

  <script>
    $("#registerForm").submit(function(e) {
      e.preventDefault();

      $.ajax({
        url: "login.php",
        type: "POST",
        data: $("#registerForm").serialize(),
        success: function(data) {
          if (data == "0") {
            window.location = "home.php";
          } else if (data == "1") {
            alert("The email already exist");
          } else if (data.match("Error: ")) {
            alert(data);
          }
        }
      });

    });
  </script>

</body>

</html>