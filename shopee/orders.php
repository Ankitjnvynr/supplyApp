<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
} else
{
    $_SESSION['loggedin'];
    $user_id = $_SESSION['userId'];
    $_SESSION['userEmail'];
    $_SESSION['userName'];
}
$activeMenu = 'orders';

require_once '../partials/_db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_order']))
{

    
    $supplier_id = '0';
    echo $shopee_id = $user_id;
    $insert_query = "INSERT INTO orders ( supplier_id, shopee_id) VALUES ('$supplier_id', '$shopee_id')";

    if ($conn->query($insert_query) === TRUE)
    {
        $order_Set_query = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
        $res = $conn->query($order_Set_query);
        $row = $res->fetch_assoc();
        $iid = $row['id'];
        $order_id = crc32($iid);
        $update_order_id = "UPDATE orders SET `order_id`='$order_id' WHERE id = '$iid'";
        if ($conn->query($update_order_id) === TRUE)
        {
            echo "New record inserted successfully";

        }
    } else
    {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome:</title>
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
    <div class=" main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>
        <div class="container">
            <?php

            // $id = 'ankit kumar paul and it s not  along lenghuhkadfhjsdfhsi'; // Generate a unique ID
            // $hash = crc32($id); // Generate the CRC32 hash
            // echo $hash;
            
            ?>
            <div class="d-flex justify-content-between align-items-center">
                <form action="" method="POST">

                    <button type="submit" name="new_order" class="btn btn-success"><i
                            class="fa-solid fa-circle-plus mr-2"></i> Create Order</button>
                </form>
                <span class="fw-bold text-success">You have <span id="OrderCount">5</span> orders</span>
            </div>
        </div>
        <div class="container" id="ordersContainer">

        </div>
    </div>
    <?php
    include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/shopeeOrders.js"></script>
</body>

</html>