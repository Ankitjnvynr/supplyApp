<div style="height: 60px; width:100vw; max-width: 390px; "
    class="position-fixed bottom-0 start-50 translate-middle-x bg-white px-1">

    <hr class="p-0 m-0">
    <div class=" footer d-flex justify-content-between align-items-center">
        <div class="dashboard  position-relative  <?php if ($activeMenu == 'dashboard')
            echo 'active' ?>">
                <a href="./" class="d-flex flex-column justify-content-center align-items-center  ">
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
            <div class="dashboard position-relative <?php if ($activeMenu == 'products')
            echo 'active' ?>">
                <a href="products.php" class="d-flex flex-column justify-content-center align-items-center  ">
                    <i class="fa-solid fa-boxes-packing"></i>
                    <span>Products</span>
                </a>
            </div>
            <?php
        if ($_SESSION['userType'] == 'supplier')
        {
            ?>
            <div class="dashboard position-relative <?php if ($activeMenu == 'contacts')
                echo 'active' ?>">
                    <a href="contacts.php" class="d-flex flex-column justify-content-center align-items-center  ">
                        <i class="fa-solid fa-users"></i>
                        <span>People</span>
                    </a>
                </div>
            <?php
        }

        ?>
        <div class="dashboard position-relative <?php if ($activeMenu == 'settings')
            echo 'active' ?>">
                <a href="settings.php" class="d-flex flex-column justify-content-center align-items-center ">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </a>
            </div>

        </div>
    </div>