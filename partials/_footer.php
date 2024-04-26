<hr class="p-0 m-0">
<div class=" footer d-flex justify-content-between align-items-center">
    <div class="dashboard  position-relative  <?php  if($activeMenu == 'dashboard') echo 'active' ?>">
        <a href="../supplier" class="d-flex flex-column justify-content-center align-items-center  ">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>
    </div>
    <div class="dashboard position-relative <?php if ($activeMenu == 'orders')
        echo 'active' ?>">
        <a href="orders.php" class="d-flex flex-column justify-content-center align-items-center  ">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Orders</span>
        </a>
    </div>
    <div class="dashboard position-relative <?php if ($activeMenu == 'shopkeepers')
        echo 'active' ?>">
        <a href="shopkeepers.php" class="d-flex flex-column justify-content-center align-items-center  ">
            <i class="fa-solid fa-users"></i>
            <span>Shopkeepers</span>
        </a>
    </div>
    <div class="dashboard position-relative <?php if ($activeMenu == 'settings')
        echo 'active' ?>">
        <a href="settings.php" class="d-flex flex-column justify-content-center align-items-center ">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
    </div>

</div>