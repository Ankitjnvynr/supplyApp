<?php
require_once '../partials/_db.php';

// Retrieve data from POST request
echo $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
echo "<br>";
echo $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
echo "<br>";

if ($order_id > 0)
{
    // Prepare and bind
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("ii", $status, $order_id);

    // Execute the query
    if ($stmt->execute())
    {
        echo "Order status updated successfully.";
    } else
    {
        echo "Error updating order status: " . $conn->error;
    }

    // Close statement
    $stmt->close();
} else
{
    echo "Invalid order ID.";
}

// Close connection
$conn->close();
?>
