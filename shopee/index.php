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
$activeMenu = 'dashboard';
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
    <link rel="stylesheet" href="../css/orders.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <div class=" main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>
        <div class="container">
            <div class="d-flex align-items-center gap-3 mt-3">
                <div style="height: 70px; width:70px; background:var(--clr4);" class="img  border rounded rounded-pill">
                    <!-- <img src="" alt=""> -->
                </div>
                <div class="info ">
                    <h2 class="p-0 m-0 fw-bolder text-success"><?php echo ucwords($_SESSION['userName']) ?></h2>
                    <span class="text-muted"><?php echo ucwords($_SESSION['shop_name']) ?></span>
                </div>
            </div>
            <div class="mt-4">
                <span class="fs-7  fw-semibold">Sales Analytics</span>
                <div class="d-flex justify-content-between align gap-2">
                    <div class="border border-success-subtle rounded-4 text-center w-100 py-2">
                        <span class="fs-7 mt-3">
                            Today's Sales
                        </span>
                        <p class="fs-5  fw-bolder m-0">₹5000</p>
                    </div>
                    <div class="border border-success-subtle rounded-4 text-center w-100 py-2">
                        <span class="fs-7 mt-3">
                            Last 30 Days
                        </span>
                        <p class="fs-5 fw-bolder m-0">₹50000</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <span class="fs-7  fw-semibold">Latest Orders</span>
                <div id="latestOrders" class="">

                </div>
            </div>
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
    <script src="../js/shopee.js"></script>
    <script src="../js/shopeeOrders.js"></script>

</body>

</html>