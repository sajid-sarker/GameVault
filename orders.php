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
  <div class="heading">
    <h3>your orders</h3>
</div>

<section class="placed-orders">

  <h1 class="title">Placed orders</h1>

  <div class="box-container">

    <?php
      // Get list of ordered
      $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($order_query) > 0){
        while($fetch_orders = mysqli_fetch_assoc($order_query)){
    ?>
    <div class="box">
        <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
        <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
        <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
        <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
        <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
        <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
        <p> your orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
        <p> total price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
        <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
        </div>
    <?php
      }
    }else{
        echo '<p class="empty">no orders placed yet!</p>';
    }
    ?>
  </div>

</section>




  
  <?php include 'footer.php' ?>
</body>
    
</html>