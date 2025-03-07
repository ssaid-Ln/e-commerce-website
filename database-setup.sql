-- Create database
CREATE DATABASE IF NOT EXISTS simple_ecommerce;
USE simple_ecommerce;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Sample products
INSERT INTO products (name, description, price, stock) VALUES
('T-Shirt', 'Comfortable cotton t-shirt', 19.99, 100),
('Jeans', 'Classic blue jeans', 49.99, 50),
('Sneakers', 'Casual sneakers for everyday wear', 59.99, 30),
('Watch', 'Stylish analog watch', 99.99, 20),
('Backpack', 'Durable backpack for daily use', 39.99, 40),
('Sunglasses', 'UV protection sunglasses', 29.99, 60),
('Hoodie', 'Warm hoodie for cold days', 34.99, 45),
('Water Bottle', 'Stainless steel water bottle', 24.99, 70);
