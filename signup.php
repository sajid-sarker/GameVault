<?php

include 'config.php';

if(isset($_POST['submit'])){
    // Assigning data received from req to variables
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];

    // Checking if user exists
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass';") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $message[] = 'User already exists!';
    }
    else{
        if($pass != $cpass){    // Password matching
            $message[] = 'Passwords do not match!';
        }
        else{  // Insert into DB
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('Query Failed');
            $message[] = 'You have been successfully registered!';
            header('location: login.php');   // Redirects user to the login page. 
            exit();
        }
   }
}
?>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css" />
</head>

<body>

    <?php include 'navbar.php' ?>

    <div class="container col-xl-10 col-xxl-8 px-2 py-4">
        <h2 style="text-align: center;">Sign up</h2>
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" method="post" action="">
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Name" required>
                    <label for="floatingName">Full name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="cpassword" class="form-control" id="floatingPassword" placeholder="Confirm Password" required>
                    <label for="floatingCPassword">Confirm Password</label>
                </div>
                <div class="form-floating mb-3">
                    <!-- <label for="user_type">Choose user type</label> -->
                    <select name="user_type" id="user_type" class="form-select" required>
                        <option value="choice" selected disabled>Choose user type</option>
                        <option value="admin">Admin</option>
                        <option value="user">Customer</option>
                    </select> 
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Sign up</button>
                <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
                <hr class="my-4">
                <small class="text-body-secondary">Already a member? <a href="./login.php">Login</a></small><br>
            </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>



</html>