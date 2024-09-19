<?php

include 'config.php';

session_start();
// $user_id =  $_SESSION['user_id'] if true or null if false
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if(isset($_POST['add_to_cart'])){

    if(!isset($user_id)){
       header('location:login.php');
    }
    // Assign product details to variables
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'Already added to cart!';
    }
    else{
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css" />
</head>

<?php include 'navbar.php' ?>

<body>
    <h1 class="text-center mt-3">Products</h1>
    <div class="container-fluid">
        <div class="row mt-5 mx-5 justify-content-center gap-3 row-cols-sm-2 row-cols-md-4">
            <?php

            // Get list of products from db
            // Product attributes : id, name, price, image
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed');
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
                    <!-- Dynamically fill in product details -->
              <div class="col-md-3 col-sm-6">
                <div class="card p-2">
                  <img class="card-img-top" src="./images/disc/<?php echo $fetch_products['image']; ?>" alt="<?php echo $fetch_products['name']; ?>">
                  <div class="card-body">
                    <h3 class="card-title"><?php echo $fetch_products['name']; ?></h3>
                    <p class="card-text">$<?php echo $fetch_products['price']; ?></p>
                  </div>
                  <div class="card-body">
                    <div class="row g-3">
                      <form method="post" action="">
                      <div class="col-12">
                        <!-- <label for="number" class="form-label">Quantity</label> -->
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="number" min="1" value="1" name="product_quantity" class="form-control mb-3" id="quantity" placeholder="Quantity">
                      </div>
                      <div class="col-12">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <button name="add_to_cart" type="submit" class="btn btn-primary">Add to Cart</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php
                }
            } 
            else {
                echo '<p class="text-center">No products found</p>';
            }
            ?>
        </div>
    </div>
    
    <?php include 'footer.php' ?>

</body>


</html>