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
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Class Connect: List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link href="css/custom.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="container col-xl-10 col-xxl-10 px-4 py-5">
    <div class="row align-items-center align-self-center g-lg-5 py-5 w-100">
      <!-- CC: LIST -->
      <div class="col-lg-7 text-lg-s+tart w-10">
        <h1 class="display-4 fw-bold lh-1 mb-3">Class Connect: List</h1>
        <p class="col-lg-10 fs-2">A centralized checklist for students, <newLine>made by students.</newLine>
        </p>
      </div>
      <!-- LOGIN BOX -->
      <div class="col-md-10 mx-auto col-lg-5">
        <!-- box size -->
        <div class="p-4 p-md-5 border rounded-3 bg-light">
          <form id="loginForm">
            <div class="form-floating mb-3">
              <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
              <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary">Login</button>
            <hr class="my-4">
          </form>

          <button class="w-100 btn btn-outline-success" onClick="location.href='signup.php'">Create a new account</button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <!--JQUERY CDN-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>

  <script>
    $("#loginForm").submit(function(e) {
      e.preventDefault();

      $.ajax({
        url: "login.php",
        type: "POST",
        data: $("#loginForm").serialize(),
        success: function(data) {
          if (data == "0") {
            window.location = "home.php";
          } else if (data == "1") {
            alert("Incorrect email or password");
          }
        }
      });

    });
  </script>



</body>

</html>