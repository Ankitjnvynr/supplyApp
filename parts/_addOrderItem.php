<?php
require_once '../partials/_db.php';
echo $orderID = $_POST['orderID'];
$sql = "INSERT INTO `order_items`( `order_id`) VALUES ('$orderID')";
$res = $conn->query($sql);
if($res){
    echo "added";
}else{
    echo $conn->error;
}
?>