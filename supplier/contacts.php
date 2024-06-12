<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
} else
{
    $_SESSION['loggedin'];
    $_SESSION['userId'];
    $_SESSION['userEmail'];
    $_SESSION['userName'];
}
if ($_SESSION['userType'] == 'shopee')
{
    header('location:../login/handlelogin.php');
    exit;
}

$activeMenu = 'settings';
$submenu = 'contacts';
require_once '../partials/_db.php';

// Pagination setup
$limit = 10; // Number of entries to show per page
if (isset($_GET["page"]))
{
    $page = $_GET["page"];
} else
{
    $page = 1;
}
$start_from = ($page - 1) * $limit;

// Handle profile update

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

    <div class="main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>

            <div style="height:60%" class="d-flex flex-wrap gap-1">

                <?php
                // Fetch paginated data
                $sql = "SELECT * FROM `users` WHERE user_type = 'shopee' LIMIT $start_from, $limit";
                $result = $conn->query($sql);
                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
                        $address = $row['city'] . ', ' . $row['tehsil'] . ', ' . $row['district'] . ', ' . $row['state'] . ' - ' . $row['pin_code'];
                        ?>
                        <div style="flex-basis:45%"
                            class="card flex-grow-1 flex-shrink-0 overflow-hidden shadow-sm border border-success-subtle">
                            <div
                                style="background-image: url('../pics/shopbanner.jpg'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: flex-end; height: 100px;">
                                <h5 class="fs-6 fw-bold"
                                    style="margin: 0; padding: 10px; background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.5) 100%); color: white; width: 100%; text-align: center; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                    <?php echo $row['shop_name']; ?>
                                </h5>

                            </div>
                            <div class="px-1">
                                <p class="m-0 p-0 fs-7">Owner: <span
                                        class="fw-semibold"><?php echo ucwords($row['name']); ?></span></p>
                                <p class="m-0 p-0 fs-7">Phone: <span class="fw-semibold"><?php echo $row['phone']; ?></span></p>
                                <p class="m-0 p-0 fs-7">Address: <span class="fw-medium"><?php echo $address ?></span></p>
                            </div>
                            <hr class="m-0">
                            <div class="d-flex flex-wrap gap-1 p-1">
                                <a style="flex-basis:50px;"
                                    class="fs-6 flex-grow-1 flex-shrink-0 shadow-sm rounded-pill px-2 text-success text-decoration-none border "
                                    href="tel:<?php echo $row['phone'] ?>">
                                    <i class="fa-solid fa-phone-volume"></i>
                                    call
                                </a>
                                <a style="flex-basis:50px;"
                                    class="fs-6 flex-grow-1 flex-shrink-0 shadow-sm rounded-pill px-2 text-success text-decoration-none border "
                                    href="https://wa.me/91<?php echo $row['phone'] ?>  ">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    W/A
                                </a>
                                <select style="flex-basis:50px;"
                                    class="form-select-sm p-0 m-0 fs-6 border rounded rounded-pill text-success flex-grow-1 flex-shrink-0 "
                                    name="" id="">
                                    <option value="">select Route</option>
                                    <?php
                                    $routes = ['Radaur', 'Ladwa', 'Karnal', 'YNR'];
                                    foreach ($routes as $key => $value)
                                    {
                                        echo '<option value="' . $value . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <?php
                    }
                }

                ?>
            </div>
            <!-- Pagination -->
             <hr>
            <nav aria-label="Page navigation example my-2">
                <ul class="pagination pagination-sm justify-content-center">
                    <?php
                    $sql = "SELECT COUNT(id) FROM users WHERE user_type = 'shopee'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_row();
                    $total_records = $row[0];
                    $total_pages = ceil($total_records / $limit);
                    for ($i = 1; $i <= $total_pages; $i++)
                    {
                        echo "<li class='page-item";
                        if ($i == $page)
                            echo " active";
                        echo "'><a class='page-link' href='contacts.php?page=" . $i . "'>" . $i . "</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>

        <?php
        include '../partials/_footer.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0Tci