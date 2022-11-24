<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <p class="title">SIGN-UP</p><br>
            <p class="para">Create an account to manage your<br>
            to-dos.</p><br>
        </div>

        <div class="form">
            <form action="includes/signup.inc.php" method="post">
                <!-- Full name must be split to F name, M name, L name -->
                <!-- Use <input typ"text" required> -->
                <label>FULLNAME</label>
                <input type="text" name="fullname" placeholder="ex. Juan Dela Cruz" required>
                <!-- Every type on the contact number must check the database if the number already exist -->
                <label>CONTACT NUMBER</label>
                <input type="number" name="contact" placeholder="ex. 09123456780">
                <!-- Every type on the email must check the database if the email exist -->
                <label>EMAIL</label>
                <input type="email" name="email" placeholder="Example@mail.com">
                <!-- Require password -->
                <label>PASSWORD</label>
                <input type="password" name="pwd" placeholder="Password">
                <!-- Every type on password must check if the password and retype password is the same -->
                <!-- Once the password are matching remove the disabled attribute  -->
                <label>RE-TYPE PASSWORD</label>
                <input type="password" name="repwd" placeholder="Re-Type Password">
                <!--<button><a class="regbtn" href="homepage.html">REGISTER</a></button>-->
                <button class="regbtn" type="submit" name="submit" disabled>REGISTER</button>
                <hr>
                <button><a class="lrdbtn" href="../index.php">ALREADY HAVE AN ACCOUNT?</a></button>
            </form>
        </div>
    </div>

</body>
</html>