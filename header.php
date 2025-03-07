<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP E-commerce</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo a {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }
        nav ul {
            display: flex;
            list-style: none;
        }
        nav li {
            margin-left: 20px;
        }
        nav a {
            text-decoration: none;
            color: #333;
        }
        h1 {
            margin-bottom: 20px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .product-card {
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 5px;
        }
        .product-card h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            background: #333;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }
        .button.primary {
            background: #4CAF50;
        }
        .button.small {
            padding: 4px 8px;
            font-size: 12px;
        }
        .product-detail {
            margin-bottom: 40px;
        }
        .product-detail .price {
            font-size: 20px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .product-detail .description {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th, .cart-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .cart-table .total {
            font-weight: bold;
        }
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        footer {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 1px solid #eee;
            text-align: center;
        }
        .error {
            color: #f44336;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">SimpleShop</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?route=cart">Cart <?php echo !empty($_SESSION['cart']) ? '(' . array_sum($_SESSION['cart']) . ')' : ''; ?></a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="#">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
                    <li><a href="index.php?route=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="index.php?route=login">Login</a></li>
                    <li><a href="index.php?route=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>