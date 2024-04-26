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

<div class=" pt-3">
    <div class="d-flex justify-content-between align-items-center position-sticky top-0">
        <h6 class="text-success fw-bolder">
            <?php
            echo ($activeMenu == 'dashboard') ? "Welcome: ".ucfirst($_SESSION['userName']) : ucfirst($activeMenu);
            ?>
        </h6>
        <div class="d-flex gap-3 fs-5">
            <!-- <a href="#"><i class="fa-solid fa-camera text-muted"></i></a> -->
            <a href="../login/logout.php"><i class="fa-solid fa-right-from-bracket text-muted"></i></a>
        </div>
    </div>
    <div class="rounded-pill bg-secondary-subtle p-2 px-3 d-flex align-items-center mb-2">
        <i class="fa-solid fa-magnifying-glass fs-6"></i>
        <input class="search-input m-0 p-0  bg-none px-2" type="text" placeholder="search....">
    </div>
</div>