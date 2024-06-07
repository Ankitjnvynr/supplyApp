<?php
require_once '../partials/_db.php';

if (isset($_POST['product']))
{
    $productid = intval($_POST['product']);

    // Proceed with deletion
    // Prepare the first statement to delete from orders table
    $stmt1 = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    if (!$stmt1)
    {
        echo "Error preparing statement 1: " . $conn->error;
        exit;
    }
    $stmt1->bind_param("i", $productid);

    if ($stmt1->execute())
    {
        if ($stmt1->affected_rows > 0)
        {
            echo "Deleted from orders table. ";

            // Prepare the second statement to delete from order_items table
            $stmt2 = $conn->prepare("DELETE FROM `order_items` WHERE order_id = ?");
            if (!$stmt2)
            {
                echo "Error preparing statement 2: " . $conn->error;
                exit;
            }
            $p = crc32($productid);
            $stmt2->bind_param("i", $p);

            if ($stmt2->execute())
            {
                if ($stmt2->affected_rows > 0)
                {
                    echo "Deleted from order_items table.";
                } else
                {
                    echo "No matching record found in order_items table after initial check.";
                }
            } else
            {
                echo "Error deleting from order_items: " . $stmt2->error;
            }

            $stmt2->close();
        } else
        {
            echo "No matching record found in orders table.";
        }
    } else
    {
        echo "Error deleting from orders: " . $stmt1->error;
    }

    $stmt1->close();

} else
{
    echo 'Product ID not provided.';
}

$conn->close();
?>