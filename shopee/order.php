<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
}
$activeMenu = 'orders';
$submenu = 'My Order';
require_once '../partials/_db.php';
?>
<?php

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
            ?>
        </div>
        <div class="container">

            <p class="fw-semibold text-muted"> ORDER ID: <span
                    class="text-success fw-bold"><?php echo $_GET['order'] ?></span></p>

            <table>
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // Retrieve data from the database
                    $sql = "SELECT * FROM order_items";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0)
                    {
                        // Output data of each row
                        while ($row = $result->fetch_assoc())
                        {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td class='editable' contenteditable='true'>" . $row["product_name"] . "</td>";
                            echo "<td class='editable' contenteditable='true'>" . $row["type"] . "</td>";
                            echo "<td class='editable' contenteditable='true'>" . $row["brand"] . "</td>";
                            echo "<td class='editable' contenteditable='true'>" . $row["qty"] . "</td>";
                            echo "<td class='editable' contenteditable='true'>" . $row["subtotal"] . "</td>";
                            echo "</tr>";
                        }
                    } else
                    {
                        echo "<tr><td colspan='6'>0 results</td></tr>";
                    }

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
    <script src="../js/categories.js"></script>
</body>

</html>