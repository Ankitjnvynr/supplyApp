<?php
require_once '../partials/_db.php';
$product = $_POST['product'];
$delSql = "DELETE FROM `products` WHERE `id`= $product ";
// $delSql = "SELECT * from `products`";    
$result = $conn->query($delSql);
if ($result)
{
    echo '1';
} else
{
    echo '0';
}
?>