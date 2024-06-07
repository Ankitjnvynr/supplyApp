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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_order']) && isset($_POST['selected_Supplier']))
{
    $supplier_id = $_POST['selected_Supplier'];

    $shopee_id = $user_id;
    $insert_query = "INSERT INTO orders ( supplier_id, shopee_id) VALUES ( '$shopee_id','$supplier_id')";

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
            // echo "New record inserted successfully";

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
    <!-- Create order Modal -->
    <div class="modal fade" id="crateOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-sm">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select class="form-select " name="selected_Supplier" aria-label="Default select example"
                            required>
                            <option value="" selected>Select Shopee</option>
                            <?php
                            $suppliers = "SELECT * FROM `users` WHERE user_type = 'shopee' ORDER BY name ASC";
                            $result = $conn->query($suppliers);
                            while ($row = $result->fetch_assoc())
                            {
                                echo '<option value="' . $row['id'] . '">' . $row['shop_name'] . ' ->' . ucfirst($row['name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="new_order" class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- create order modal end -->



    <div class=" main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crateOrderModal"
                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                    <i class="fa-solid fa-circle-plus mr-2"></i> Create New Order</button>
                </button>
                <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crateOrderModal">
                    <i class="fa-solid fa-circle-plus mr-2"></i> Create Order</button>
                </button> -->
                <span class="fw-bold fs-7 text-success">showing <span id="OrderCount1">5</span>/<span
                        id="OrderCount2">5</span> orders</span>
            </div>
            <div class="-m-2 hide-scroll-bar d-flex mt-2 gap-1 overflow-x-scroll ">
                <span onclick="resetFilter()"
                    class="filter-btn active cursor-pointer no-space-wrap bg-secondary-subtle fs-7 rounded rounded-pill px-2 p-1">All</span>
                <span onclick="dateFilter(null,7)"
                    class="filter-btn cursor-pointer no-space-wrap bg-secondary-subtle fs-7 rounded rounded-pill px-2 p-1">last
                    7 days</span>
                <span onclick="dateFilter(null,30)"
                    class="filter-btn cursor-pointer no-space-wrap bg-secondary-subtle fs-7 rounded rounded-pill px-2 p-1">last
                    30 days</span>
                <span
                    class="filter-btn cursor-pointer no-space-wrap bg-secondary-subtle fs-7 rounded rounded-pill px-2 p-1 d-flex gap-2">
                    <input class="filter-date-input" id="startDate" class="fs-7" type="date">
                    <span class="text-success fw-bold">TO</span>
                    <input class="filter-date-input" id="endDate" class="fs-7" type="date">

                </span>
            </div>

        </div>
        <div class="container mt-2" id="ordersContainer">

        </div>

        <div class="container mt-3">
            <div id="loadMoreBtn" class=" fs-7 fw-semibold btn btn-outline-success float-end  p-0 px-2">load
                More...</div>
        </div>
        <div id="loadingAnimation" style="display:none;position:fixed;bottom:10px;right:10px;">
            <img style="width:50px;" src="../pics/loading.gif" alt="Loading...">
        </div>
    </div>
    <?php
    include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="../js/supplierOrder.js"></script>
</body>

</html>