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
require_once '../partials/_db.php';

$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 5;

$sql = "SELECT * FROM `orders` WHERE shopee_id = $user_id ORDER BY id DESC LIMIT $start,$limit" ;
$res = $conn->query($sql);
$nums = $res->num_rows;
if ($nums > 0)
{
    while ($row = $res->fetch_assoc())
    {
        // fetching supplier details 
        $supplier_id = $row['supplier_id'];
        $supplier = "SELECT * FROM `users` WHERE id = $supplier_id";
        $suppResult = $conn->query($supplier);
        $supplierRow = $suppResult->fetch_assoc();
        $Supplier_name = $supplierRow['name'];
        $Supplier_store_name = $supplierRow['shop_name'];
        $Supplier_phone = $supplierRow['phone'];
        ?>
        <div class=" orderBox  mt-2 p-1 px-2 border border-success-subtle">
            <div class="d-flex justify-content-between">
                <p class="fs-7 m-0 fw-semibold text-muted">
                    ORDER ID:<span class="text-success"><?php echo $row['order_id']; ?></span>
                </p>
                <p class="fs-7 m-0 fw-semibold text-muted opacity-50">
                    <?php echo $row['dt']; ?>
                </p>
            </div>
            <p class="fs-5 fw-bold m-0">
                <?php echo $Supplier_store_name ?> <a class="fs-7 text-success text-decoration-none"
                    href="tel:<?php echo $Supplier_phone ?>">(<?php echo ucfirst($Supplier_name) ?>) <i
                        class="fa-solid fa-phone"></i></a>
            </p>
            <p class="m-0 fs-7 text-muted">You Ordered: Pensil, Erasor, Oyes, .....</p>
            <div class="d-flex gap-2">
                <a href="order.php?order=<?php echo $row['order_id']; ?>"
                    class=" flex-item-btn btn btn-success fs-7 m-1 rounded-pill p-1"><i class="fa-brands fa-readme"></i> View
                    Order</a>
                <button onclick="deleteOrder(this, <?php echo $row['id'] ?>)" type="button"
                    class=" flex-item-btn btn btn-outline-danger fs-7 m-1 rounded-pill p-1"><i class="fa-solid fa-trash"></i>
                    Delete</button>

            </div>
        </div>
        <?php
    }
} else
{
    echo '<div class="text-center text-muted mt-5">No order found</div>';
}
?>