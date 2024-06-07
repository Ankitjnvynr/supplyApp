<?php
session_start();
require_once '../partials/_db.php';

$sql = "SELECT * FROM `users` WHERE user_type = 'shopee'";
$result = $conn->query($sql);
echo $result->num_rows;
