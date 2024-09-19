<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/styles.css" />
</head>
    
<body>

  <?php include 'navbar.php' ?>


<section id="placed-orders">

  <h1 class="text-center my-5">Placed orders</h1>

  <section id="orders">

    <div class="container">
      <div class="row g-4">
        <?php
          // Fetch all the users from db
          $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
          if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
        ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card bg-body-tertiary h-100">
            <div class="card-body">
              <h5 class="card-title">Name: <?php echo $fetch_orders['name']; ?></h5>
              <h6 class="card-subtitle my-2 text-body-secondary">User ID: <?php echo $fetch_orders['user_id']; ?></h6>
              <p class="card-text">Placed on: <?php echo $fetch_orders['placed_on']; ?></p>
              <p class="card-text">Phone: <?php echo $fetch_orders['number']; ?></p>
              <p class="card-text">Email: <?php echo $fetch_orders['email']; ?></p>
              <p class="card-text">Address: <?php echo $fetch_orders['address']; ?></p>
              <p class="card-text">Ordered products: <?php echo $fetch_orders['total_products']; ?></p>
              <p class="card-text">Total price: $<?php echo $fetch_orders['total_price']; ?></p>
              <p class="card-text">Payment method: <span class="text-capitalize"><?php echo $fetch_orders['method']; ?></span></p>
              <p class="card-text">Payment status: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo ucfirst($fetch_orders['payment_status']); ?></span></p>
            </div>
          </div>
        </div>
        <?php
            }
          }
          else{
            echo '<p class="text-center">No orders placed yet</p>';
          }
        ?>

  </section>
  
  <?php include 'footer.php' ?>

</body>
    
</html>