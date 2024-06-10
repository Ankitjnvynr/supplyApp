<?php
session_start();

require_once '../partials/_db.php';

$pid = isset($_POST['pId']) ? $_POST['pId'] : "";
$qty = isset($_POST['qty']) ? $_POST['qty'] : "";

$shopee_id = $_SESSION['userID'];
$sql = "SELECT * FROM `orders` WHERE shopee_id = '$shopee_id' AND status = 1 ORDER BY id DESC LIMIT 1 ";
$res = $conn->query($sql);
if ($res->num_rows > 0)
{
    $row = $res->fetch_assoc();
    $orderID = $row['order_id'];

    $productSql = "SELECT * FROM `products` WHERE id = $pid LIMIT 1";
    $products = $conn->query($productSql);
    $pr = $products->fetch_assoc();
    $productName = $pr['product_name'];
    $productType = $pr['price'];
    $productBrand = $pr['brand'];

    $subTotal = $productType*$qty;


    $sql = "INSERT INTO `order_items`( `order_id`,`product_name`, `type`, `brand`, `qty`, `subtotal`) VALUES ('$orderID','$productName','$productType','$productBrand','$qty','$subTotal')";
    $res = $conn->query($sql);
    if ($res)
    {
        echo "added";
    } else
    {
        echo $conn->error;
    }

} else
{
    echo 0;
}

?>