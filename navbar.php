<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();  // Start the session only if one is not already started
}
?>

<section id="navbar">
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php">
        <img src="images/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        Game Vault
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./about.php">About us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./products.php">Products</a>
          </li>
      </div>
      <ul class="navbar-nav">


        <!-- Dynamic links based on session -->
      <?php
        if (!isset($_SESSION['user_id'])){   // If not logged in 
          echo '
          <li class="nav-item">
            <a class="nav-link" href="./login.php">Login</a>
          </li>
          <li class="nav-item"></li>
            <a class="nav-link" href="./signup.php">Sign Up</a>
          </li>';
        } 
        else {
          echo '
          <li class="nav-item">
            <a class="nav-link" href="./cart.php">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./order.php">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>';
        }
      ?>  
      </ul>
    </div>
  </nav>
</section>