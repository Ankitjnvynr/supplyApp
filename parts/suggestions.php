<?php
require_once '../partials/_db.php';

$column = $_GET['column'];
if ($column == 'type')
{
    $column = 'price';
}
$filterProductName = isset($_GET['filterProductName']) ? $_GET['filterProductName'] : "";
$filterBrandName = isset($_GET['filterBrandName']) ? $_GET['filterBrandName'] : "";
$filterPrice = isset($_GET['filterPrice']) ? $_GET['filterPrice'] : "";

if (!empty($filterProductName) && !empty($filterBrandName) && !empty($filterPrice))
{
    $sql = "SELECT DISTINCT $column FROM products WHERE product_name = '$filterProductName' AND price = '$filterPrice' AND brand='$filterBrandName'";
} elseif (!empty($filterProductName) && !empty($filterBrandName))
{
    $sql = "SELECT DISTINCT $column FROM products WHERE product_name = '$filterProductName' AND brand='$filterBrandName'";
} elseif (!empty($filterProductName))
{
    $sql = "SELECT DISTINCT $column FROM products WHERE product_name = '$filterProductName'";
} else
{
    $sql = "SELECT DISTINCT $column FROM products";
}

// Adjust your query and table name
$result = $conn->query($sql);

$suggestions = [];
if ($result->num_rows > 0)
{
    while ($row = $result->fetch_assoc())
    {
        $suggestions[] = $row[$column];
    }
}

$conn->close();

echo json_encode($suggestions);
?>