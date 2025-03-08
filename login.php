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

<?php include 'nav.php'; ?>

<div class="d-flex justify-content-center p-5">
    <form name="loginform" method="post" action="index.php">
        <div class="border rounded border-dark p-4">
            <h3>Sign In Form</h3>
            <label>Email</label>
            <input class="form-control mb-2" type="email" name="email" id="email" placeholder="Your Email" required>

            <label>Password</label>
            <input class="form-control mb-2" type="password" name="password" id="password" placeholder="Password" required>

            <input class="bg-dark text-white form-control mb-2" type="submit" name="btnlogin" value="Sign In">

            <p><a href="forgot-password.php" id="forgotpass">Forgot Password?</a></p>
            <hr>
            <p>Do not have an account? <a href="register.php" id="signup"> Register</a></p>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnlogin"])) {

    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'ecommerce_db');

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);

    // Use prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM user_tbl WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['sess_user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }

    $stmt->close();
    mysqli_close($con);
}
?>
