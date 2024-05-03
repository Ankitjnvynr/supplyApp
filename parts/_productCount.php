<?php
session_start();
require_once '../partials/_db.php';

$sql = "SELECT * FROM `products` ORDER BY id DESC";
$result = $conn->query($sql);
echo $result->num_rows;