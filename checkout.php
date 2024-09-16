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
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';  // Array of products

    // Asks for products currently in cart
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){   // If cart is not empty

        // Go thru returned data and 
        while($cart_item = mysqli_fetch_assoc($cart_query)){    // 
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
        $total_products = implode(', ',$cart_products);
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
      <h3>Checkout</h3>
    </div>

    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-pill">4</span>
        </h4>
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">Product name</h6>
                    <small class="text-body-secondary">Brief description</small>
                </div>
            <span class="text-body-secondary">$12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">Second product</h6>
                    <small class="text-body-secondary">Brief description</small>
                </div>
                <span class="text-body-secondary">$8</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">Third item</h6>
                    <small class="text-body-secondary">Brief description</small>
                </div>
                <span class="text-body-secondary">$5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$20</strong>
            </li>
        </ul>

        <section id="info">
        </div>
        <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation" method="post" action="" novalidate="">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="firstName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Enter your name" value="" required>
                    <div class="invalid-feedback">
                    Valid first name is required.
                    </div>
                </div>

                <div class="col-6">
                    <label for="number" class="form-label">Phone no.</label>
                    <input type="tel" class="form-control" id="number" placeholder="Enter your number">
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="you@example.com">
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Flat no, House no, Road" required>
                </div>

                <div class="col-12">
                    <label for="address2" class="form-label">Address 2</label>
                    <input type="text" class="form-control" id="address2" placeholder="Sector, Village, etc." required>
                </div>

            </div>

            <hr class="my-4">

            <h4 class="mb-3">Payment method</h4>

            <div class="my-3">
                <div class="form-check">
                    <input id="credit" name="method" type="radio" class="form-check-input" checked="" required="">
                    <label class="form-check-label" for="bkash">bKash</label>
                </div>
                <div class="form-check">
                    <input id="debit" name="method" type="radio" class="form-check-input" required="">
                    <label class="form-check-label" for="nagad">Nagad</label>
                </div>
                <div class="form-check">
                    <input id="paypal" name="method" value=""type="radio" class="form-check-input" required="">
                    <label class="form-check-label" for="cod">Cash on Delivery</label>
                </div>
            </div>
            <hr class="my-4">
            <button class="w-100 btn btn-primary btn-lg" name="order_btn" type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
    </section>
    
    <?php include 'footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>