<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/styles.css" />
</head>
<body>
   
  <?php include 'admin_header.php'; ?>

  <section id="users">

  <h1 class="text-center my-5">User Accounts</h1>

  <div class="container">
    <div class="row g-4">
      <?php
        // Fetch all the users from db
        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
        while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card bg-body-tertiary h-100"> <!-- Ensure card has full height -->
          <div class="card-body">
            <h5 class="card-title">User ID: <?php echo $fetch_users['id']; ?></h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">Username: <?php echo $fetch_users['name']; ?></h6>
            <p class="card-text">Email: <?php echo $fetch_users['email']; ?></p>
            <p class="card-text">User type: <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'orange'; } ?>"><?php echo ucfirst($fetch_users['user_type']); ?></span></p>
            <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="btn btn-outline-danger">Delete user</a>
          </div>
        </div>
      </div>
      <?php
          };
      ?>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>