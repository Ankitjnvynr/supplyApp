<?php

require_once 'partials/_db.php';

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS users  (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_type varchar(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,  -- Make email column unique
    password VARCHAR(500) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    state VARCHAR(100),
    district VARCHAR(100),
    tehsil VARCHAR(100),
    city VARCHAR(100),
    city VARCHAR(100),
    pic TEXT,
    pin_code TEXT,
    shop_name VARCHAR(255),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the database connection
$conn->close();
