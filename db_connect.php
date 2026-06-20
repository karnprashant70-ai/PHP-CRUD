<?php
/**
 * Database Connection File
 * This file handles all database connection logic
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'php_crud');

// Create connection (without selecting database first)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Check connection to MySQL server
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
if (!$conn->select_db(DB_NAME)) {
    die("Error selecting database: " . $conn->error);
}

// Create products table if it doesn't exist
$createTableSql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    category VARCHAR(100),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
)";

if (!$conn->query($createTableSql)) {
    die("Error creating table: " . $conn->error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?>
