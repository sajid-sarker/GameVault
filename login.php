<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){  // If submitted data exists and !null

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('Query Failed');

   if(mysqli_num_rows($select_users) > 0){  // If user exists
    // Returns the result row as a dictionary
    $row = mysqli_fetch_assoc($select_users);

  if($row['admin_access'] == 'TRUE'){

        $_SESSION['admin_name'] = $row['name'];
        $_SESSION['admin_email'] = $row['email'];
        $_SESSION['admin_id'] = $row['id'];
        header('location:admin_page.php');

    }
    elseif($row['user_type'] == 'user'){

        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css" /></head>

<?php include 'navbar.php' ?>

<body>
    <div class="container col-xl-10 col-xxl-8 px-2 py-4">
        <h2 style="text-align: center;">Log in</h2>
        <div class="row align-items-center g-lg-5 py-5">
          <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" method="POST" action="">
              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>
              <button class="w-100 btn btn-lg btn-primary" type="submit">Log in</button>
              <hr class="my-4">
              <small class="text-body-secondary">Not a member? <a href="./signup.php">Sign up</a></small>
            </form>
          </div>
        </div>
      </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

<?php include 'footer.php' ?>

</html>