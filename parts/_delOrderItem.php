<?php
require_once '../partials/_db.php';
$orderID = $_POST['orderID'];
$sql = "DELETE FROM `order_items` WHERE `order_items`.`id` = $orderID";
$res = $conn->query($sql);
if($res){
    echo "added";
}else{
    echo $conn->error;
}
?>