<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
    exit;
}
if ($_SESSION['userType'] == 'supplier')
{
    header('location:../login/handlelogin.php');
    exit;
}

$activeMenu = 'products';
require_once '../partials/_db.php';


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProduct']))
{
    // Fetch values from form
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];

    // Prepare SQL statement to insert data into products table
    $sql = "INSERT INTO products (product_name, price, qty, brand, category) VALUES (?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $product_name, $price, $qty, $brand, $category);

    try
    {
        // Execute the statement
        if ($stmt->execute() === TRUE)
        {
            // echo "New record created successfully";
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
    <link rel="stylesheet" href="../css/product.css">
</head>

<body>
    <!-- =========toast notification============ -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="ErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <!-- <img src="..." class="rounded me-2" alt="..."> -->
                <i id="toastIcon" class="fa-solid text-danger fa-circle-exclamation "></i>
                <strong id="toastType" class="me-auto mx-2">Alert</strong>
                <small>0 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="ToastBody" class="toast-body">
                Error! Product already Exist.
            </div>
        </div>
    </div>

    <div class=" main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>
        <div class="container d-flex align-items-center justify-content-between text-muted m-0">
            <div class="d-flex flex-column gap-0">
                <h6 id="productCount" class="fs-6 fw-bold bg-success text-white rounded-pill px-2 m-0   text-center">5
                </h6>
                <span class="fs-7 m-0 p-0">Total</span>
            </div>
            <div class="rounded rounded-pill bg-secondary-subtle d-flex align-items-center gap-2 px-1">
                <select id="filterCat" class="form-select form-select-sm rounded rounded-pill bg-secondary-subtle"
                    aria-label="Small select example">
                    
                    <?php
                    include '../parts/_loadCategory.php';
                    ?>

                </select>
                <?php
                if ($_SESSION['userType'] == 'supplier')
                {
                    ?>
                <a href="categories.php">
                    <i data-bs-toggle="modal"
                        class="fa-solid fa-plus  text-white p-1 px-3 rounded-pill bg-secondary"></i>
                </a>
                <?php
                }
                ?>
            </div>
            <?php
            if ($_SESSION['userType'] == 'supplier')
            {
                ?>
                <i data-bs-toggle="modal" data-bs-target="#addProductModal"
                    class="fa-solid fa-circle-plus fs-1 text-success"></i>
                <?php
            }
            ?>
        </div>
        <div id="porductBox" class="container text-sm ">


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
    <script src="../js/product.js"></script>

    <script>
        <?php
        if (isset($errorFound))
        {
            echo 'showNoti("fa-circle-exclamation","Alert","This poduct alredy exist")';
        }
        ?>
    </script>
</body>

</html>