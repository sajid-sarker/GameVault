<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){   // Checks if user logged in 
  header('location: login.php');
}

if(isset($_POST['order_btn'])){

  // Assigning form data to variables
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $number = $_POST['number'];
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $method = mysqli_real_escape_string($conn, $_POST['method']);
  $address = mysqli_real_escape_string($conn, $_POST['flat'].', '. $_POST['street'].', '. $_POST['area'] .', '.$_POST['city']);
  $placed_on = date('d-M-Y');

  $cart_total = 0;
  $cart_products = [];  // Array of products

  // Asks for products currently in cart
  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  if(mysqli_num_rows($cart_query) > 0){   // If cart is not empty

    while($cart_item = mysqli_fetch_assoc($cart_query)){    // 
      // Go thru returned data and add to array
      $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
      $sub_total = ($cart_item['price'] * $cart_item['quantity']);
      $cart_total += $sub_total;
    }
  }
  
  if(!$cart_products){
    $total_products = 'None';
  }
  else{
    // implode() concats all arr elements into a str
    $total_products = implode(', ', $cart_products);
  }

  // Checking if same order already made before
  $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' 
  AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products'
  AND total_price = '$cart_total'") or die('Query failed');

  if($cart_total == 0){
    $message[] = 'Your cart is empty';
  }
  else{
    if(mysqli_num_rows($order_query) > 0){
      $message[] = 'Order already placed!'; 
    }
    else{
      mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) 
      VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
      $message[] = 'Order placed successfully!';
      // Empty cart once order is placed
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    }
  }
  // Redirect after form processing to prevent resubmission
  header("location: orders.php");
  exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/styles.css" />
</head>

<body class="bg-body-tertiary">
    
  <?php include 'navbar.php' ?>

  <div class="container">
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="./images/logo.svg" alt="" width="72" height="57">
      <h1>Checkout</h1>
    </div>
  
  <div class="row g-5">
    <!-- Billing information -->
    <section id="info" class="col-md-7 col-lg-8">
      <h3 class="mb-3">Billing address</h3>
      <form class="needs-validation" method="post" action="" novalidate="">
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="" required>
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>

          <div class="col-6">
            <label for="number" class="form-label">Phone no.</label>
            <input type="tel" name="number" class="form-control" id="number" placeholder="Enter your number">
          </div>

          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
          </div>

          <div class="col-12">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="flat" class="form-control" id="address" placeholder="Flat no, House no, Road" required>
          </div>

          <div class="col-12">
            <label for="address2" class="form-label">Address 2</label>
            <input type="text" name="street" class="form-control" id="address2" placeholder="Sector, Village, etc." required>
          </div>

          <div class="col-6">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" id="city" placeholder="e.g. Dhaka" required>
          </div>

          <div class="col-6">
            <label for="area" class="form-label">Area</label>
            <input type="text" name="area" class="form-control" id="area" placeholder="e.g. Gulshan" required>
          </div>
        </div>

        <hr class="my-4">

        <h4 class="mb-3">Payment method</h4>

        <div class="my-3">
          <div class="form-check">
            <input id="bkash" name="method" type="radio" value="bkash" class="form-check-input" checked="" required="">
            <label class="form-check-label" for="bkash">bKash</label>
          </div>
          <div class="form-check">
            <input id="nagad" name="method" type="radio" value="nagad" class="form-check-input" required="">
            <label class="form-check-label" for="nagad">Nagad</label>
          </div>
          <div class="form-check">
            <input id="cod" name="method" value="cod" type="radio" class="form-check-input" required="">
            <label class="form-check-label" for="cod">Cash on Delivery</label>
          </div>
          <div class="form-check">
            <input id="paypal" name="method" value="paypal" type="radio" class="form-check-input" required="">
            <label class="form-check-label" for="paypal">Paypal</label>
          </div>
        </div>

        <hr class="my-4">
        <button class="w-100 btn btn-primary btn-lg" name="order_btn" type="submit">Order now</button>
      </form>
    </section>


    <!-- Cart items -->
    
      <!-- Number of items chosen -->
      <?php
        $result = mysqli_query($conn, "SELECT COUNT(quantity) AS total_items FROM `cart` WHERE user_id = '$user_id'") or die('Query failed: '.mysqli_error($conn));
        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result); 
          $total_items = $row['total_items'];
        } 
        else {
          $total_items = 0; // Default to 0 if no rows were returned
        }
      ?>

      <!-- Number of items chosen and cart summary -->
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill"><?php echo $total_items ;?></span>
        </h4>
        <ul class="list-group mb-3">
          <?php  
          $grand_total = 0;
          $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
          if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
              $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
              $grand_total += $total_price;
          ?>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo $fetch_cart['name']; ?></h6>
              <p class="text-body-secondary">(<?php echo '$'.$fetch_cart['price'].' x '.$fetch_cart['quantity']; ?>)</p>
            </div>
            <span class="text-body-secondary">$<?php echo $total_price; ?></span>
          </li>  
          <?php
            }
          } else {
            echo '<p class="my-3">Your cart is empty</p>';
          }
          ?>     
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$<?php echo $grand_total; ?></strong>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <?php include 'footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>