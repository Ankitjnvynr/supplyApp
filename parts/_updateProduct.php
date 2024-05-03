<?php
require_once '../partials/_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Fetch values from form
    $productKey = $_POST['productKey'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];

    // Prepare SQL statement to update data in products table
    $sql = "UPDATE products SET  product_name = ?, price = ?, qty = ?, brand = ?, category = ? WHERE id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissss", $product_name, $price, $qty, $brand, $category, $productKey);

    try
    {
        // Execute the statement
        if ($stmt->execute())
        {
            // $stmt->execute();
            $affectedRows = $stmt->affected_rows;
            echo $affectedRows;
        } else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } catch (\Throwable $th)
    {
        //throw $th;
        $messageArray = $th;
        $errorFound = true;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

?>