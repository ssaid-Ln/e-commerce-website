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

// Functions
function displayHomePage($conn) {
    // Fetch products from database
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 12";
    $result = $conn->query($sql);
    
    echo "<h1>Welcome to Our Shop</h1>";
    echo "<div class='product-grid'>";
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<p>$" . number_format($row['price'], 2) . "</p>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<a href='index.php?route=product&id=" . $row['id'] . "' class='button'>View Details</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No products available.</p>";
    }
    
    echo "</div>";
}

function displayProduct($conn) {
    if (!isset($_GET['id'])) {
        echo "<p>Product not found.</p>";
        return;
    }
    
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        echo "<div class='product-detail'>";
        echo "<h1>" . htmlspecialchars($product['name']) . "</h1>";
        echo "<p class='price'>$" . number_format($product['price'], 2) . "</p>";
        echo "<div class='description'>" . htmlspecialchars($product['description']) . "</div>";
        
        // Add to cart form
        echo "<form method='post' action='index.php?route=cart'>";
        echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1' max='10'>";
        echo "<button type='submit' name='add_to_cart' class='button'>Add to Cart</button>";
        echo "</form>";
        
        echo "</div>";
    } else {
        echo "<p>Product not found.</p>";
    }
}

function displayCart($conn) {
    // Add product to cart
    if (isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        // Add or update cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
    
    // Remove from cart
    if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
        unset($_SESSION['cart'][$_GET['remove']]);
    }
    
    echo "<h1>Shopping Cart</h1>";
    
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
        echo "<a href='index.php' class='button'>Continue Shopping</a>";
        return;
    }
    
    echo "<table class='cart-table'>";
    echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>";
    
    $total = 0;
    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $subtotal = $product['price'] * $quantity;
            $total += $subtotal;
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['name']) . "</td>";
            echo "<td>$" . number_format($product['price'], 2) . "</td>";
            echo "<td>$quantity</td>";
            echo "<td>$" . number_format($subtotal, 2) . "</td>";
            echo "<td><a href='index.php?route=cart&remove=$product_id' class='button small'>Remove</a></td>";
            echo "</tr>";
        }
    }
    
    echo "<tr class='total'><td colspan='3'>Total</td><td>$" . number_format($total, 2) . "</td><td></td></tr>";
    echo "</table>";
    
    echo "<div class='cart-actions'>";
    echo "<a href='index.php' class='button'>Continue Shopping</a>";
    echo "<a href='index.php?route=checkout' class='button primary'>Proceed to Checkout</a>";
    echo "</div>";
}

function processCheckout($conn) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<p>Please <a href='index.php?route=login'>login</a> to complete your order.</p>";
        return;
    }
    
    // Check if cart is empty
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
        return;
    }
    
    // Process order submission
    if (isset($_POST['place_order'])) {
        $user_id = $_SESSION['user_id'];
        
        // Calculate total
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "SELECT price FROM products WHERE id = $product_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                $total += $product['price'] * $quantity;
            }
        }
        
        // Create order in database
        $sql = "INSERT INTO orders (user_id, total, order_date, status) VALUES ($user_id, $total, NOW(), 'pending')";
        if ($conn->query($sql) === TRUE) {
            $order_id = $conn->insert_id;
            
            // Add order items
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $sql = "SELECT price FROM products WHERE id = $product_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    $price = $product['price'];
                    
                    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
                    $conn->query($sql);
                }
            }
            
            // Clear cart
            $_SESSION['cart'] = [];
            
            echo "<h1>Order Placed</h1>";
            echo "<p>Your order has been successfully placed. Order ID: #$order_id</p>";
            echo "<a href='index.php' class='button'>Continue Shopping</a>";
            return;
        } else {
            echo "<p>Error placing order: " . $conn->error . "</p>";
            return;
        }
    }
    
    // Display checkout form
    echo "<h1>Checkout</h1>";
    
    // Show order summary
    echo "<h2>Order Summary</h2>";
    
    echo "<table class='cart-table'>";
    echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";
    
    $total = 0;
    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $subtotal = $product['price'] * $quantity;
            $total += $subtotal;
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['name']) . "</td>";
            echo "<td>$" . number_format($product['price'], 2) . "</td>";
            echo "<td>$quantity</td>";
            echo "<td>$" . number_format($subtotal, 2) . "</td>";
            echo "</tr>";
        }
    }
    
    echo "<tr class='total'><td colspan='3'>Total</td><td>$" . number_format($total, 2) . "</td></tr>";
    echo "</table>";
    
    // Checkout form
    echo "<form method='post' action='index.php?route=checkout'>";
    echo "<h2>Shipping Information</h2>";
    
    echo "<div class='form-group'>";
    echo "<label for='address'>Address</label>";
    echo "<input type='text' id='address' name='address' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='city'>City</label>";
    echo "<input type='text' id='city' name='city' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='zip'>ZIP Code</label>";
    echo "<input type='text' id='zip' name='zip' required>";
    echo "</div>";
    
    echo "<h2>Payment Information</h2>";
    
    echo "<div class='form-group'>";
    echo "<label for='card_number'>Card Number</label>";
    echo "<input type='text' id='card_number' name='card_number' placeholder='1234 5678 9012 3456' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='expiry'>Expiry Date</label>";
    echo "<input type='text' id='expiry' name='expiry' placeholder='MM/YY' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='cvv'>CVV</label>";
    echo "<input type='text' id='cvv' name='cvv' placeholder='123' required>";
    echo "</div>";
    
    echo "<button type='submit' name='place_order' class='button primary'>Place Order</button>";
    echo "</form>";
}

function handleLogin($conn) {
    $error = '';
    
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                
                // Redirect
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
    }
    
    echo "<h1>Login</h1>";
    
    if ($error) {
        echo "<p class='error'>$error</p>";
    }
    
    echo "<form method='post' action='index.php?route=login'>";
    
    echo "<div class='form-group'>";
    echo "<label for='email'>Email</label>";
    echo "<input type='email' id='email' name='email' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='password'>Password</label>";
    echo "<input type='password' id='password' name='password' required>";
    echo "</div>";
    
    echo "<button type='submit' name='login' class='button primary'>Login</button>";
    echo "</form>";
    
    echo "<p>Don't have an account? <a href='index.php?route=register'>Register</a></p>";
}

function handleRegistration($conn) {
    $error = '';
    
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email already registered";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user
            $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            
            if ($stmt->execute()) {
                // Auto login
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $name;
                
                // Redirect
                header("Location: index.php");
                exit;
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
    
    echo "<h1>Register</h1>";
    
    if ($error) {
        echo "<p class='error'>$error</p>";
    }
    
    echo "<form method='post' action='index.php?route=register'>";
    
    echo "<div class='form-group'>";
    echo "<label for='name'>Name</label>";
    echo "<input type='text' id='name' name='name' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='email'>Email</label>";
    echo "<input type='email' id='email' name='email' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='password'>Password</label>";
    echo "<input type='password' id='password' name='password' required>";
    echo "</div>";
    
    echo "<button type='submit' name='register' class='button primary'>Register</button>";
    echo "</form>";
    
    echo "<p>Already have an account? <a href='index.php?route=login'>Login</a></p>";
}

// Close database connection
$conn->close();
?>
