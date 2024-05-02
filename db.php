<?php

require_once 'partials/_db.php';

// SQL to create table
$userSql = "CREATE TABLE IF NOT EXISTS users  (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_type varchar(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,  -- Make email column unique
    password VARCHAR(500) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    state VARCHAR(100),
    district VARCHAR(100),
    tehsil VARCHAR(100),
    city VARCHAR(100),
    pic TEXT,
    pin_code TEXT,
    shop_name VARCHAR(255),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

function runsql($conn, $sql)
{
    if ($conn->query($sql) === TRUE)
    {
        echo "Table users created successfully <br>";
        // var_dump($sql);
    } else
    {
        echo "Error creating table: " . $conn->error;
    }
}

runsql($conn, $userSql);

// product table creation--------------------->
$products = "CREATE TABLE IF NOT EXISTS products(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_name TEXT,
    price INT(6) NOT NULL,
    qty INT(6) NOT NULL,
    brand VARCHAR(50),
    category VARCHAR(20),
    add_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_product_combination (product_name, price, brand, category)
)";

runsql($conn, $products);

//category of the products
$categories = "CREATE TABLE IF NOT EXISTS categories(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(100) NOT NULL UNIQUE,
    dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

runsql($conn, $categories);




// Close the database connection
$conn->close();
