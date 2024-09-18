<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){  // If not logged in
   header('location:login.php');
};

// When product is added to store
if(isset($_POST['add_product'])){

  // Assign post data to variables
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $price = $_POST['price'];

  if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];  // og name of image
    $image_size = $_FILES['image']['size']; // size of image
    $image_tmp_name = $_FILES['image']['tmp_name']; //tmp filepath where img is stored before being moved.
    $image_folder = './images/disc/'.$image;  // dir
  }

  $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('Query failed');

  if(mysqli_num_rows($select_product_name) > 0){
    $message[] = 'Product already added';
  }
  else{
    // Returns true if successful
    $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('Query failed');

    if($add_product_query){ // If true
        if($image_size > 5000000){  // If image greater than 5MB
          $message[] = 'Image size is too large';
        }
        else{
          // Moves img to final location
          move_uploaded_file($image_tmp_name, $image_folder);
          $message[] = 'Product added successfully!';
        }
    }
    else{ // Error message
        $message[] = 'Product could not be added!';
    }
  }
  // Redirect after form processing to prevent resubmission
  header('Location: admin_products.php');
  exit(); 
}

// Deleting product
if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('Query failed');
  $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
  unlink('./images/disc/'.$fetch_delete_image['image']);
  mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('Query failed');
  header('location:admin_products.php');
  exit();
}

// Updating product info
if(isset($_POST['update_product'])){

  // Get info of product to update
  $update_p_id = $_POST['update_p_id'];
  $update_name = $_POST['update_name'];
  $update_price = $_POST['update_price'];

  mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('Query failed');

  // Updating the image
  $update_image = $_FILES['update_image']['name'];
  $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
  $update_image_size = $_FILES['update_image']['size'];
  $update_folder = './images/disc/'.$update_image;
  $update_old_image = $_POST['update_old_image'];


  if(!empty($update_image)){
    if($update_image_size > 2000000){
      $message[] = 'Image file size is too large';
    }
    else{
      // Image update query
      mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('Query failed');
      move_uploaded_file($update_image_tmp_name, $update_folder);
      unlink('./images/disc/'.$update_old_image);
    }
  }
  header('location:admin_products.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/styles.css" />
  <link rel="stylesheet" href="./styles/products.css" />
</head>

<body>
   
  <?php include 'admin_header.php' ?>
  
  <h1 class="text-center mt-3">Manage Products</h1>
  
  <!-- Add products -->
  <section id="add_product">
    <div class="container mt-5">
      <div class="row g-5 justify-content-center ">
        <div class="col-sm-9 col-lg-5 py-3 border border-2 rounded">
          <h4 class="mb-3 pt-2 text-center">Add Product</h4>
          <form class="p-2" method="post" action="" enctype="multipart/form-data">
            <div class="row g-3">
              <div class="col-12">
                <label for="productName" class="form-label">Product name</label>
                <input type="text" class="form-control" name="name" id="productName" placeholder="Enter product name" required>
              </div>

              <div class="col-12">
                <label for="price" class="form-label">Price</label>
                <input type="number" min="0" class="form-control" name="price" id="price" 
                  placeholder="Enter price" required>
              </div>

              <div class="col-12">
                <label for="image" class="form-label">Choose file</label>
                <input type="file" class="form-control" accept="image/jpg, image/jpeg, image/png" 
                  name="image" id="image" placeholder="No file chosen" required>
              </div>
            </div>
            <hr class="my-4">
            <button class="w-100 btn btn-primary btn-lg" name="add_product" type="submit">Add</button>
          </form>
        </div>
      </div>
    </div>
  </section>


  <!-- Show store products -->
  <section id="show_all">
    <div class="container-fluid">
      <div class="row mt-5 mx-5 justify-content-center gap-3 row-cols-sm-2 row-cols-md-4">
        <?php

        // Get list of products from db
        // Product attributes : id, name, price, image
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed');
        if(mysqli_num_rows($select_products) > 0){
          // fetch_products is dict with the data for a product
          while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <!-- Dynamically fill in product details -->
            <div class="col-md-3 col-sm-6">
              <div class="card p-2">
                <img class="card-img-top" src="./images/disc/<?php echo $fetch_products['image']; ?>" 
                  alt="<?php echo $fetch_products['name']; ?>">
                <div class="card-body">
                  <h3 class="card-title"><?php echo $fetch_products['name']; ?></h3>
                  <p class="card-text">$<?php echo $fetch_products['price']; ?></p>
                </div>
                <div class="card-body d-flex justify-content-center gap-2">
  
                  <!-- Update Form -->
                  <form method="post" action="a">
                    <button type="button" class="btn btn-warning" onclick="openUpdateModal(<?php echo $fetch_products['id']; ?>, '<?php echo $fetch_products['name']; ?>', '<?php echo $fetch_products['price']; ?>', '<?php echo $fetch_products['image']; ?>')">Update</button>
                  </form>

                  <!-- Delete Form -->
                  <form method="get" action="">
                    <input type="hidden" name="delete" value="<?php echo $fetch_products['id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
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
  </section>

  <?php include 'footer.php' ?>

  <!-- Bootstrap script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="./js/admin_product.js"></script>

  <!-- Modal(Pop-up) for Updating Product -->
  <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="p-2" method="post" action="" enctype="multipart/form-data" id="updateProductForm">
            <input type="hidden" name="update_p_id" id="update_p_id" />
            <input type="hidden" name="update_old_image" id="update_old_image" />
            
            <div class="mb-3">
              <label for="update_name" class="form-label">Product Name</label>
              <input type="text" class="form-control" name="update_name" id="update_name" required>
            </div>

            <div class="mb-3">
              <label for="update_price" class="form-label">Price</label>
              <input type="number" min="0" class="form-control" name="update_price" id="update_price" required>
            </div>

            <div class="mb-3">
              <label for="update_image" class="form-label">Choose File</label>
              <input type="file" class="form-control" accept="image/jpg, image/jpeg, image/png" name="update_image" id="update_image">
            </div>

            <div class="mb-3">
              <img id="current_product_image" class="img-fluid" alt="Current Product Image" />
            </div>

            <button type="submit" class="btn btn-warning w-100" name="update_product">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>