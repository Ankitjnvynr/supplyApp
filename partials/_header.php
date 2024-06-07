<style>
    .search-input {
        background: transparent;
        outline: none;
        border: none;
        width: 100%;
    }

    .search-input:active {
        background: transparent !important;
        outline: none;
    }
</style>
<!-- logout confirm modal  -->




<div class=" pt-3">
    <div style="height:30px; overflow:hidden; width:300px;"
        class="position-fixed m-auto bg-success d-none align-items-center justify-content-center">
        logout
    </div>
    <div class="d-flex justify-content-between align-items-center position-sticky top-0">
        <h6 class="text-success fw-bolder d-flex align-items-center justify-content-center ">
            <?php
            if (isset($submenu))
            {
                echo '<a class="text-success" href="' . $activeMenu . '.php" >';
            }
            echo ($activeMenu == 'dashboard') ? "Welcome: " . ucfirst($_SESSION['userName']) : ucfirst($activeMenu);
            if (isset($submenu))
            {
                echo '</a><span class="fs-4" >></span>' . $submenu;
            }
            ?>


        </h6>
        
    </div>
    <div class="rounded-pill bg-secondary-subtle p-2 px-3 d-flex align-items-center mb-2">
        <i class="fa-solid fa-magnifying-glass fs-6"></i>
        <input id="searchBox" class="search-input m-0 p-0  bg-none px-2" type="text" placeholder="search....">
    </div>
</div>

