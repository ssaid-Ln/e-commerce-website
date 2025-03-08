<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Said Ecommerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<?php  include 'nav.php'; ?>
<?php  include 'dbcon.php'; ?>
    <form class=" d-flex justify-content-center p-5" name="loginform" method="get" action="confirm.php">
        
            <div class="border rounded border-dark p-4">
            <h3>Sign Up Form</h3>
                <input class="form-control mb-2" type="text" name="form_username" id="username" placeholder="UserName">
                <input class="form-control mb-2" type="text" name="form_email" id="email" placeholder="Email">
                <input class="form-control mb-2" type="text" name="form_password" id="password" placeholder="Password">
                <!-- <input type="password" name="password2" id="password2" placeholder="Cornfirm Password"><br><br> -->
                <input class="bg-dark text-white form-control mb-2" type="submit" name="btnlogin" id="btnlogin" value="Register">
                                
                <p><input class="m-2" type="checkbox" name="terms&condition" id="terms">I agree to the <a href="#" id="terms2"> Terms & Condition</a></p>

                <hr>
                <p>Already Sign Up <a href="login.php" id="signup"> Sign In</a></p>
                
            </div>
        </div>
    </div>
    </form>
    </div>
</div>

<?php  include 'footer.php'; ?>

</body>
</html>