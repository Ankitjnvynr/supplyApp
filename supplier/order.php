<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
}
$activeMenu = 'orders';
$submenu = 'My Order';
require_once '../partials/_db.php';

$orderID = $_GET['order'];

$check = "SELECT * FROM orders WHERE order_id = $orderID";
// Check if order_id exists
$resu = $conn->query($check);
$count = $resu->num_rows;
if ($count == 0)
{
    $orderStatus = "Sorry! order Not Found";

} else
{
    $data = $resu->fetch_assoc();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_GET['order'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/orders.css">


</head>

<body>

    <div class="main">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            if (isset($orderStatus))
            {
                echo $orderStatus;
                exit;
            }
            ?>
        </div>
        <div class="container">
            <div class="d-flex justify-content-between">
                <p class="fw-semibold text-muted"> ORDER ID: <span
                        class="text-success fw-bold"><?php echo $_GET['order'] ?></span>
                </p>
                <div class="form-check form-switch form-check-reverse text-success ">
                    <input onchange="changeOrderStatus(this, <?php echo $_GET['order'] ?>)" class="form-check-input"
                        type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo $data['status'] == '1' ? 'checked=true' : '' ?>>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Editable</label>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>*</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // Retrieve data from the database
                    $sql = "SELECT * FROM order_items WHERE order_id = '$orderID'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0)
                    {
                        // Output data of each row
                        $sr = 0;
                        while ($row = $result->fetch_assoc())
                        {
                            $sr++;
                            echo "<tr>";
                            echo "<td>" . $sr . "</td>";
                            echo "<td class='editable' contenteditable='true' data-column='product_name' data-id='" . $row["id"] . "'>" . $row["product_name"] . "</td>";
                            echo "<td class='editable' contenteditable='true' data-column='brand' data-id='" . $row["id"] . "'>" . $row["brand"] . "</td>";
                            echo "<td class='editable price' contenteditable='true' data-column='type' data-id='" . $row["id"] . "'>" . $row["type"] . "</td>";
                            echo "<td class='editable qty' contenteditable='true' data-column='qty' data-id='" . $row["id"] . "'>" . $row["qty"] . "</td>";
                            echo "<td class='subtotal' data-id='" . $row["id"] . "'>" . $row["subtotal"] . "</td>";
                            echo "<td class='p-0 fs-6' onclick='deleteProductItem(" . $row["id"] . ")'><i class='fa-regular text-danger fa-trash-can'></i></td>";
                            echo "</tr>";
                        }
                    } else
                    {
                        echo "<tr><td colspan='7'>0 results</td></tr>";
                    }
                    echo "<tr><td colspan='7'><div onclick='addNewItem(" . $_GET['order'] . ")' class='btn btn-outline-success p-0 m-0 fs-7 px-2'>Add New Row</div></td></tr>";

                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        include '../partials/_footer.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../js/supplierOrder.js"></script>
    <script src="../js/order.js"></script>
    <script src="../js/sugession.js"></script>


</body>

</html>