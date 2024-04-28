<hr>
<?php
session_start();
require_once '../partials/_db.php';

$sql = "SELECT * FROM `products`";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc())
{


    ?>

    <div class=" p-1 mt-2 text-muted ">
        <div class="row ">
            <div class="col-11">
                <div class="d-flex">
                    <div class="text-success fw-semibold"><?php echo $row['product_name'] ?><span
                            class="fw-normal text-muted fs-7">
                            (Stationary)</span> </div>
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
                        <?php echo $row['qty'] ?>
                    </div>
                </div>
            </div>
            <div class="col-1 fs-4 d-flex flex-column gap-2 px-1">
                <i class="fa-solid fa-pen-to-square text-success"></i>
                <i class="fa-solid fa-trash text-danger"></i>
            </div>
        </div>
    </div>
    <?php
}

?>