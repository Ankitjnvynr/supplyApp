<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
} else
{
    $_SESSION['loggedin'];
    $_SESSION['userId'];
    $_SESSION['userEmail'];
    $_SESSION['userName'];
}
$activeMenu = 'orders';
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
            <span class="fw-bold fs-7 text-success">Showing <span id="OrderCount1">5</span>/<span id="OrderCount2">5</span> orders</span>

            <div style="margin-bottom: -12px;" class="-m-2 hide-scroll-bar d-flex mt-2 gap-1 overflow-x-scroll ">
                <span onclick="loadOrders(null, null, 0, 5)"
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
        <div id="ordersContainer" class="container "></div>
    </div>
    <?php
    include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/supplierOrder.js"></script>
</body>

</html>