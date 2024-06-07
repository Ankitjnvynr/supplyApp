<?php
session_start();
require_once '../partials/_db.php';
$userID = $_SESSION['userID'];
$settingSql = "SELECT * FROM `users` WHERE id = '$userID' ";
$result = $conn->query($settingSql);
while ($row = $result->fetch_assoc()) {
    $userName = $row['name'];
    $userEmail = $row['email'];
    $phone = $row['phone'];
    $city = $row['city'];
    $tehsil = $row['tehsil'];
    $district = $row['district'];
    $state = $row['state'];
    $pin = $row['pin_code'];
    $address =  $city . ', ' . $row['tehsil'] . ', ' . $row['district'] . ', ' . $row['state'] . ' - ' . $row['pin_code'];
    $shopName = $row['shop_name'];
    $userType = $row['user_type'];
}


?>
<!-- ======== information edit modal ========= -->
<div class="modal fade" id="EditInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form class="" action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-success" id="exampleModalLabel">Edit Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label-sm">Name</label>
                        <input class="form-control form-control-sm" id="name" name="name" type="text" aria-label=".form-control-sm example" value="<?php echo ucwords(strtolower($userName)) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label-sm">Phone</label>
                        <input class="form-control form-control-sm" id="phone" name="phone" type="text" value="<?php echo $phone ?>" aria-label=".form-control-sm example" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label-sm">State</label>
                        <input class="form-control form-control-sm" id="state" name="state" type="text" value="<?php echo $state ?>" aria-label=".form-control-sm example" required>
                    </div>
                    <div class="mb-3">
                        <label for="district" class="form-label-sm">District</label>
                        <input class="form-control form-control-sm" id="district" name="district" type="text" value="<?php echo $district ?>" aria-label=".form-control-sm example" required>
                    </div>
                    <div class="mb-3">
                        <label for="tehsil" class="form-label-sm">Tehsil</label>
                        <input class="form-control form-control-sm" id="tehsil" name="tehsil" type="text" value="<?php echo $tehsil ?>" aria-label=".form-control-sm example" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label-sm">City/Village</label>
                        <input class="form-control form-control-sm" id="city" name="city" type="text" value="<?php echo $city ?>" aria-label=".form-control-sm example" required>
                    </div>
                    <div class="mb-3">
                        <label for="pin_code" class="form-label-sm">Pin Code</label>
                        <input class="form-control form-control-sm" id="pin_code" name="pin_code" type="text" value="<?php echo $pin; ?>" aria-label=".form-control-sm example" required>
                    </div>
                    <div class="mb-3">
                        <label for="shop_name" class="form-label-sm">
                            <?php
                            if ($_SESSION['userType'] == 'supplier') {
                                echo "Store Name";
                            } else {
                                echo "Shop Name";
                            }
                            ?>
                        </label>
                        <input class="form-control form-control-sm" value="<?php echo $shopName ?>" id="shop_name" name="shop_name" type="text" aria-label=".form-control-sm example" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updaeProfileInfo" class="btn btn-success">Update Info</button>
                </div>
        </form>
    </div>
</div>
</div>
<!-- ======== information edit modal end ========= -->
<div class="container-fluid py-1 mb-3" style="background-color:var(--clr2)">
    <div class="editprofilebtn float-end fw-bold text-success">
        <button data-bs-toggle="modal" data-bs-target="#EditInfoModal" class="btn">Edit <i class="fa-regular fa-pen-to-square"></i></button>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <div style="height:60px; width:60px;" class="pic rounded-circle bg-secondary"></div>
        <div class="infoj p-0">
            <p class="fs-5 fw-bold p-0 m-0"><?php echo ucwords(strtolower($userName)) ?></p>
            <p class="text-muted p-0 m-0 fs-6"><?php echo $phone ?></p>
        </div>
    </div>
</div>
<div style="height:60%" class="d-flex flex-column justify-content-between  ">
    <div class="">
        <div class="container mb-3 d-flex  gap-2  align-items-center text-muted">
            <span class=" p-0 m-0"><i class="fa-solid fa-envelope"></i></span>
            <p class="p-0 m-0"><?php echo strtolower($userEmail) ?></p>
        </div>
        <span class="text-success subheading container">
            <?php
            if ($_SESSION['userType'] == 'supplier') {
                echo "Store ";
            } else {
                echo "Shop ";
            }
            ?>
            Information:</span>
        <div class="container  d-flex  gap-2  align-items-center text-muted">
            <span class="w-2 p-0 m-0"><i class="fa-solid fa-store"></i></span>
            <p class="p-0 m-0 fw-bold"><?php echo ucwords(strtolower($shopName)) ?></p>
        </div>
        <div class="container  d-flex  gap-2   text-muted">
            <span class="w-2 p-0 m-0"><i class="fa-solid fa-location-dot"></i></span>
            <p class="p-0 m-0 "><?php echo $address ?></p>
        </div>
    </div>
    <!-- <div class="text-muted text-center">You are registered as <?php echo ($userType == 'shopee') ? 'Shop Keeper' : 'Supplier' ?></div> -->
</div>