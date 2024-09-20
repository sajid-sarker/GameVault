<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
   integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="./styles/styles.css" />

   <style>
      .card-title{
         color: purple;
      }
   </style>
</head>
<body>
   
  <?php include 'admin_header.php'; ?>

  <section class="dashboard">
    <h1 class="text-center my-3">Dashboard</h1>
    <div class="container">
      <div class="row text-center">

        <!-- Pending payments -->
        <?php 
          $total_pendings = 0;
          $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
          if(mysqli_num_rows($select_pending) > 0){
            while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
              $total_price = $fetch_pendings['total_price'];
              $total_pendings += $total_price;
            };
          };
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card box-shadow h-100">
              <div class="card-header">
                  <h3 class="card-title">Pending Payments</h3> 
              </div>
              <div class="card-body">
                  <p class="my-0 font-weight-normal display-5">$<?php echo $total_pendings; ?></p>
              </div>
            </div>
        </div>

        <!-- Completed Payment -->
        <?php 
          $total_completed = 0;
          $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
          if(mysqli_num_rows($select_completed) > 0){
            while($fetch_completed = mysqli_fetch_assoc($select_completed)){
              $total_price = $fetch_completed['total_price'];
              $total_completed += $total_price;
            };
          }; 
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card box-shadow h-100">
              <div class="card-header">
                  <h3 class="card-title">Completed Payments</h3> 
              </div>
              <div class="card-body">
                  <p class="my-0 font-weight-normal display-5">$<?php echo $total_completed; ?></p>
              </div>
            </div>
        </div>
      
        <!-- Products Added Card -->

        <?php // Retrieving data for no. of products
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card box-shadow h-100">
            <div class="card-header">
              <h3 class="card-title">Products Added</h3> 
            </div>
            <div class="card-body">
              <p class="my-0 font-weight-normal display-5"><?php echo $number_of_products; ?></p>
            </div>
          </div>
        </div>


        <!-- Orders Placed Card -->

        <?php 
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
          $number_of_orders = mysqli_num_rows($select_orders); 
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card box-shadow h-100">
            <div class="card-header">
              <h3 class="card-title">Orders Placed</h3> 
            </div>
            <div class="card-body">
              <p class="my-0 font-weight-normal display-5"><?php echo $number_of_orders; ?></p>
            </div>
          </div>
        </div>

        <!-- Customers Card -->

        <?php 
          $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
          $number_of_users = mysqli_num_rows($select_users);
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card box-shadow h-100">
            <div class="card-header">
              <h3 class="card-title">Customers</h3> 
            </div>
            <div class="card-body">
              <p class="my-0 font-weight-normal display-5"><?php echo $number_of_users; ?></p>
            </div>
          </div>
        </div>

        <!-- Admins Card -->

        <?php 
          $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
          $number_of_admins = mysqli_num_rows($select_admins);
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card box-shadow h-100">
            <div class="card-header">
              <h3 class="card-title">Admins</h3> 
            </div>
            <div class="card-body">
              <p class="my-0 font-weight-normal display-5"><?php echo $number_of_admins; ?></p>
            </div>
          </div>
        </div>

        <!-- Total Users Card -->

        <?php 
          $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
          $number_of_account = mysqli_num_rows($select_account);
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card box-shadow h-100">
            <div class="card-header">
              <h3 class="card-title">Total Users</h3> 
            </div>
            <div class="card-body">
              <p class="my-0 font-weight-normal display-5"><?php echo $number_of_account; ?></p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

   <?php include 'footer.php' ?>

   <!-- custom admin js file link  -->
   <!-- <script src="js/admin_script.js"></script> -->

</body>
</html>