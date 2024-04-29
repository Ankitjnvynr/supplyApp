<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProduct']))
{
    // Fetch values from form
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];

    // Prepare SQL statement to update data in products table
    $sql = "UPDATE products SET price = ?, qty = ?, brand = ?, category = ? WHERE product_name = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $price, $qty, $brand, $category, $product_name);

    try
    {
        // Execute the statement
        if ($stmt->execute() === TRUE)
        {
            echo "Record updated successfully";
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