<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css" />
    <style>
        .bg-image {
            background-image: url("./images/cyberpunk.jpeg");
            background-size: cover;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>
    
    <!-- Checkout link for test  -->
    <a href="./checkout.php">checkout</a>

    <section id="product" class="bg-image">
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-primary ">
        
        <div class="col-md-6 p-lg-5 mx-auto my-5">
            
        <h1 class="display-3 fw-bold">GAME VAULT</h1>
        <h3 class="fw-normal mb-3">Your one stop shop for video games</h3>
        
        <div class="d-flex gap-3 justify-content-center lead fw-normal">
            
            <a class="icon-link " href="#">
            Learn more
            </a>
            <a class="icon-link" href="#">
            Buy
            </a>
        </div>
        </div>
    </div>
    </section> 

    <h2 class="fw-normal my-3 text-center">Latest Arrivals</h2>
    <section>

    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
        </div>
        <div class="carousel-inner">
        <div class="carousel-item">
            <img src="./images/elden_ring.jpg"  class="d-block w-100 h-50">
            <div class="container">
            <div class="carousel-caption text-start">
                <h1>Elden Ring</h1>
                <p class="opacity-75">Rise, Tarnished, and be guided by grace to brandish the power of the Elden Ring and become an Elden Lord in the Lands Between.</p>
                <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
            </div>
            </div>
        </div>
        <div class="carousel-item active">
            <img src="./images/sekiro.jpg"  class="d-block w-100 h-50">          
            <div class="container">
            <div class="carousel-caption">
                <h1>Sekrio: Shados Die Twice</h1>
                <p>Carve your own clever path to vengeance in the award winning adventure from developer FromSoftware, creators of Bloodborne and the Dark Souls series.</p>
                <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
            </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./images/ghost.jpg"  class="d-block w-100 h-50">          
            <div class="container">
            <div class="carousel-caption text-end">
                <h1>Ghost of Tsushima</h1>
                <p>Uncover the hidden wonders of Tsushima in this open-world action adventure from Sucker Punch Productions and PlayStation Studios.</p>
                <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
            </div>
            </div>
        </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>
    </section>

    <section id="hero">
    <div class="bg-light text-secondary px-4 py-5 text-center">
        <div class="py-5">
        <h1 class="display-5 fw-bold text-dark">Connect with fellow enthusiasts</h1>
        <div class="col-lg-6 mx-auto">
            <p class="fs-5 mb-4">Meet new people by joining our community today!</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley" class="btn btn-outline-primary btn-lg px-4 me-sm-3 fw-bold">Join</a>
            </div>
        </div>
        </div>
    </div>
    <div class="b-example-divider mb-0"></div>
    </section>
    
    <?php include 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script src="./script.js"></script> -->
</body>

</html>