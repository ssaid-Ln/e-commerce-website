<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Said Ecommerce</title>
</head>
<body>

<?php  include 'nav.php'; ?>

<div class="container">
        <h1 class="m-4">Accessories</h1>
    <div class="d-flex flex-wrap justify-content-m-center">

    <div class="card m-2" style="width: 18rem;">
        <img class="card-img-top" src="./assets/asus.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">ASUS Laptop E210MA-TB</h5>
            <p class="card-text"style="color:red; "><b>₱12,495.00</b></p>
            <a href="#" class="btn btn-dark">Add To Cart</a>
        </div>
    </div>    

    <div class="card m-2" style="width: 18rem;">
        <img class="card-img-top" src="./assets/iphone.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Apple iphone 14 PRO Max</h5>
            <p class="card-text"style="color:red; "><b>₱67,000.00</b></p>
            <a href="#" class="btn btn-dark">Add To Cart</a>
        </div>
    </div>    

    <div class="card m-2" style="width: 18rem;">
        <img class="card-img-top" src="./assets/headphones.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Bluetooth Headphones</h5>
            <p class="card-text"style="color:red; "><b>₱1,500.00</b></p>
            <a href="#" class="btn btn-dark">Add To Cart</a>
        </div>
    </div>    

    <div class="card m-2" style="width: 18rem;">
        <img class="card-img-top" src="./assets/speaker.png" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Fantech Speaker</h5>
            <p class="card-text"style="color:red; "><b>₱ 500.00</b></p>
            <a href="#" class="btn btn-dark">Add To Cart</a>
        </div>

    </div>    
    <div class="m-5"></div>
    

    </div>
</div>

<?php  include 'footer.php'; ?>
</body>
</html>