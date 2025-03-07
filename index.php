<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "simple_ecommerce";

// Connect to database
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session for cart and user authentication
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Simple router
$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Include header
include 'header.php';

// Route to appropriate page
switch ($route) {
    case 'home':
        displayHomePage($conn);
        break;
    case 'product':
        displayProduct($conn);
        break;
    case 'cart':
        displayCart($conn);
        break;
    case 'checkout':
        processCheckout($conn);
        break;
    case 'login':
        handleLogin($conn);
        break;
    case 'register':
        handleRegistration($conn);
        break;
    case 'logout':
        session_destroy();
        header("Location: index.php");
        break;
    default:
        echo "<h1>Page Not Found</h1>";
        break;
}

// Include footer
include 'footer.php';