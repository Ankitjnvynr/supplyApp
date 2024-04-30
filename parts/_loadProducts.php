<hr>
<?php
session_start();
require_once '../partials/_db.php';

$sql = "SELECT * FROM `products`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc())
{
    ?>
    <div class=" p-1 mt-2 text-muted ">
        <div class="row ">
            <div class="col-11">
                <div class="d-flex align-items-center">
                    <div class="text-success fw-semibold"><?php echo $row['product_name'] ?></div>
                    <div class="fw-normal text-muted fs-7">
                        (
                    </div>
                    <div class="fw-normal text-muted fs-7"><?php echo $row['category'] ?></div>
                    <div class="fw-normal text-muted fs-7">
                        )
                    </div>
                </div>
                <div class="row fs-7">
                    <div class="col">
                        <i class="fa-solid fa-campground"></i>
                        <span><?php echo $row['brand'] ?></span>
                    </div>
                    <div class="col fw-semibold">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                        <span><?php echo $row['price'] ?></span>
                    </div>
                    <div class="col">
                        <i class="fa-solid fa-cubes-stacked"></i>
                        <span><?php echo $row['qty'] ?></span>
                    </div>
                </div>
            </div>
            <div class="col-1 fs-4 d-flex flex-column gap-2 px-1">
                <i onclick="openUpdateModal(this,<?php echo $row['id'] ?>)"
                    class="fa-solid fa-pen-to-square text-success"></i>
                <i class="fa-solid fa-trash text-danger"></i>
            </div>
        </div>
    </div>
    <?php
}
}else{
    echo '<div class="text-center text-muted"> No Products Found</div>';
    echo '<div class="text-center  "> <button data-bs-toggle="modal" data-bs-target="#addProductModal"  class="btn btn-outline-secondary">Add New</button></div>';
}

?>
