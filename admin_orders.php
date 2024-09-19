<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){  // Only if admin
   header('location:login.php');
}

// Update order
if(isset($_POST['update_order'])){

  $order_update_id = $_POST['order_id'];
  $update_payment = $_POST['update_payment'];
  mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
  $message[] = 'Payment status has been updated!';
  header('location: admin_orders.php');
  exit();
}
// Delete order
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/styles.css" />
</head>

<body >
   
  <?php include 'admin_header.php'; ?>

  <section id="orders">

    <h1 class="text-center my-5">Placed Orders</h1>

    <div class="container">
      <div class="row g-4">
        <?php
          // Fetch all the users from db
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
          if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
        ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card bg-body-tertiary h-100"> <!-- Ensure card has full height -->
            <div class="card-body">
              <h5 class="card-title">Name: <?php echo $fetch_orders['name']; ?></h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">User ID: <?php echo $fetch_orders['user_id']; ?></h6>
              <p class="card-text">Placed On: <?php echo $fetch_orders['placed_on']; ?></p>
              <p class="card-text">Phone: <?php echo $fetch_orders['number']; ?></p>
              <p class="card-text">Email: <?php echo $fetch_orders['email']; ?></p>
              <p class="card-text">Address: <?php echo $fetch_orders['address']; ?></p>
              <p class="card-text">Total Products: <?php echo $fetch_orders['total_products']; ?></p>
              <p class="card-text">Total Price: $<?php echo $fetch_orders['total_price']; ?></p>
              <p class="card-text">Payment Method: <?php echo $fetch_orders['method']; ?></p>
              <form action="" method="post">
                <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                <label for="update_payment">Payment Status:</label>
                <select name="update_payment" class="form-select my-3">
                  <option value="" selected disabled><?php echo ucfirst($fetch_orders['payment_status']); ?></option>
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
                </select>
                <button type="submit" value="Update" name="update_order" class="btn btn-outline-warning">Update</button>
                <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="btn btn-outline-danger">Delete</a>
              </form>
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
      </div>
    </div>

  </section>

  <?php include 'footer.php'; ?>

</body>
</html>