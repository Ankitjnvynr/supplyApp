<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
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
    <!-- =====================add product modal====================== -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form id="productForm" action="" method="POST">
                    
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="productModalLabel">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_name" class="form-label-sm">Product Name</label>
                            <input class="form-control form-control-sm" id="product_name" name="product_name"
                                type="text" aria-label=".form-control-sm example" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label-sm">Price(₹)</label>
                            <input class="form-control form-control-sm" id="price" name="price" type="text"
                                aria-label=".form-control-sm example" required>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label-sm">Stock</label>
                            <input class="form-control form-control-sm" id="qty" name="qty" type="text"
                                aria-label=".form-control-sm example" required>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label-sm">Brand</label>
                            <input class="form-control form-control-sm" id="brand" name="brand" type="text"
                                aria-label=".form-control-sm example" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="category" class="form-label-sm">Category</label>
                            <input class="form-control form-control-sm" id="category" name="category" type="text"
                                aria-label=".form-control-sm example" required>
                        </div> -->
                        <div class="mb-3">
                            <select class="form-select form-select-sm " id="category" name="category"required
                                aria-label="Small select example">
                                
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="productFormBtn" name="addProduct" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- =====================add product modal end======================] -->
    <!-- =====================update product modal====================== -->
    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form id="updateProductForm" action="" method="POST">
                    <input id="productKey" name="productKey" type="text" hidden>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="UproductModalLabel">Update Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_name" class="form-label-sm">Product Name</label>
                            <input class="form-control form-control-sm" id="product_nameU" name="product_name"
                                type="text" aria-label=".form-control-sm example" required>
                        </div>
                        <div class="mb-3">
                            <label for="priceU" class="form-label-sm">Price(₹)</label>
                            <input class="form-control form-control-sm" id="priceU" name="price" type="text"
                                aria-label=".form-control-sm example" required>
                        </div>
                        <div class="mb-3">
                            <label for="qtyU" class="form-label-sm">Stock</label>
                            <input class="form-control form-control-sm" id="qtyU" name="qty" type="text"
                                aria-label=".form-control-sm example" required>
                        </div>
                        <div class="mb-3">
                            <label for="brandU" class="form-label-sm">Brand</label>
                            <input class="form-control form-control-sm" id="brandU" name="brand" type="text"
                                aria-label=".form-control-sm example" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="categoryU" class="form-label-sm">Category</label>
                            <input class="form-control form-control-sm" id="categoryU" name="category" type="text"
                                aria-label=".form-control-sm example" required>
                        </div> -->
                        <div class="mb-3">
                            <select class="form-select form-select-sm " id="categoryU" name="category" required
                                aria-label="Small select example">
                                
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="productFormBtn" name="addProduct"
                            class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- =====================update product modal end================] -->

    <div class=" main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>
        <div class="container d-flex align-items-center justify-content-between text-muted m-0">
            <div class="d-flex flex-column gap-0">
                <h6 class="fs-6 fw-bold bg-success text-white rounded-pill px-2 m-0   text-center">5</h6>
                <span class="fs-7 m-0 p-0">Total</span>
            </div>
            <div class="rounded rounded-pill bg-secondary-subtle d-flex align-items-center gap-2 px-1">
                <select id="filterCat" class="form-select form-select-sm rounded rounded-pill bg-secondary-subtle"
                    aria-label="Small select example">
                    <option value="" selected>Category</option>
                    
                </select>
                <a href="categories.php">
                    <i data-bs-toggle="modal"
                        class="fa-solid fa-plus  text-white p-1 px-3 rounded-pill bg-secondary"></i>
                </a>
            </div>
            <i data-bs-toggle="modal" data-bs-target="#addProductModal"
                class="fa-solid fa-circle-plus fs-1 text-success"></i>
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