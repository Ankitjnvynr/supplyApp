<?php
require_once '../partials/_db.php';
$productid = $_POST['product'];
$delSql = "DELETE FROM `orders` WHERE id = '$productid'";
$result = $conn->query($delSql);
if ($result)
{
    echo '1';
} else
{
    echo '0';
}
  