<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

// When item is added to cart
if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   // Db update
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'Cart updated!';
}

// If item is deleted from cart
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

// If cart is emptied
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/styles.css" />
</head>
    
<body>

  <?php include 'navbar.php' ?>

  <h1 class="text-center mt-3">Cart</h1>

  <section class="shopping-cart">

  <div class="container-fluid">
    <div class="row mt-5 mx-5 justify-content-center gap-3 row-cols-sm-2 row-cols-md-4">
      <?php
        $grand_total = 0;
        // Get products in user cart
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
        if(mysqli_num_rows($select_cart) > 0){
          while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="col-md-3 col-sm-6">
        <div class="card p-2">
          <img class="card-img-top" src="./images/disc/<?php echo $fetch_cart['image']; ?>" alt="<?php echo $fetch_cart['name']; ?>">
          <div class="card-body">
            <h3 class="card-title"><?php echo $fetch_cart['name']; ?></h3>
            <p class="card-text">$<?php echo $fetch_cart['price']; ?></p>
          </div>
          <div class="card-body">
            <form method="post" action="">
              <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
              <input type="number" min="1" name="cart_quantity" class="form-control mb-3" value="<?php echo $fetch_cart['quantity']; ?>">
              <button name="update_cart" type="submit" value="update" class="btn btn-primary me-3">Update cart</button>
              <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger" 
              onclick="return confirm('Delete this from cart?');">Delete item</a>
            </form>
            <p class="card-text mt-3">Sub total: $<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?></p>
          </div>
        </div>
      </div>


      <?php
      $grand_total += $sub_total;
          }
      }
      else{
          echo '<p class="text-center">Your cart is empty</p>';
      }
      ?>

  </section>
   
  <section id="total-hero">
    <div class="bg-body-tertiary text-secondary px-4 py-5 text-center mt-5">
      <div class="py-5">
        <h3 class="display-5 fw-bold text-dark mb-5">Grand total: $<?php echo $grand_total; ?></h3>
        <div class="col-lg-6 mx-auto">
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="./products.php" class="btn btn-warning btn-lg px-4 me-sm-3 fw-bold">Continue shopping</button>
            <a href="./checkout.php" class="btn btn-success btn-lg px-4 <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceed to Checkout</a>
          </div>
        </div>
      </div>
    </div>
  </section>
   
  <?php include 'footer.php' ?>

</body>
    
</html>