<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
    exit;
}
if ($_SESSION['userType'] == 'shopee')
{
    header('location:../login/handlelogin.php');
    exit;
}


$activeMenu = 'products';
$submenu = 'Categories';
require_once '../partials/_db.php';
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if the category input is set and not empty
    if (isset($_POST["category"]) && !empty($_POST["category"]))
    {
        // Retrieve the category value
        $category = $_POST["category"];

        // Process the category value, for example, you can insert it into the database
        // Insert code here
        // For example:
        try
        {
            $sql = "INSERT INTO categories (cat_name) VALUES ('$category')";
            if ($conn->query($sql))
            {
                $mesge = "New Category Added";
            }
        } catch (\Throwable $th)
        {
            // echo '<pre>';
            // print_r($th);
            $ErrMesge = substr($th->getMessage(), 0, -strlen("for key 'cat_name'"));
        }
    }

    if (isset($_POST["categoryU"]) && !empty($_POST["categoryU"]) && isset($_POST["updateCatid"]))
    {
        $categoryu = $_POST["categoryU"];
        $cat_id = $_POST['updateCatid'];

        // Update the category in the database
        try
        {
            $usql = "UPDATE `categories` SET `cat_name`='$categoryu' WHERE id = $cat_id";
            if ($conn->query($usql))
            {
                $Mesge = "Update successful";
            } else
            {
                $ErrMesge = $conn->error;
            }
        } catch (\Throwable $th)
        {
            // echo '<pre>';
            // print_r($th);
            $ErrMesge = substr($th->getMessage(), 0, -strlen("for key 'cat_name'"));
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <!-- ======Modal for category Edit =========== -->

    <div class="modal fade" id="updateCatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm  modal-dialog-centered">
            <div class="modal-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateCatModalLabel">Update Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="updateCatid" name="updateCatid" type="hidden">
                        <input type="text" id="updateCatName" name="categoryU" placeholder="Type category" required
                            class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ======Modal for category Edit End =========== -->

    <div class="main">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>


        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-flex gap-2" method="POST">
                <input type="text" name="category" placeholder="Type category" required class="form-control">
                <button type="submit" class="btn btn-success">Add</button>
            </form>
            <div class="fs-7">
                <?php
                if (isset($Mesge))
                {
                    echo '<span class="text-success ">' . $Mesge . '<span>';
                }
                if (isset($ErrMesge))
                {
                    echo '<span class="text-danger">' . $ErrMesge . '<span>';
                }
                ?>
            </div>
            <hr>
            <table class="table fs-6">
                <thead>
                    <tr>
                        <th scope="col">Sr</th>
                        <th colspan="2">Category </th>
                        <th scope="col" class="text-center">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $catSql = "SELECT * FROM `categories`";
                    $result = $conn->query($catSql);
                    $sr = 1;
                    echo 'Total categories: ' . $result->num_rows;
                    while ($row = $result->fetch_assoc())
                    {

                        ?>
                        <tr>
                            <th scope="row"><?php echo $sr; ?></th>
                            <td colspan="2"><?php echo $row['cat_name']; ?></td>
                            <td class="text-center fs-5">
                                <i onclick="editCat(this,<?php echo $row['id']; ?>)"
                                    class="fa-solid fa-pen-to-square px-1 text-success"></i>
                                <i onclick="deleteCat(<?php echo $row['id']; ?>)"
                                    class="fa-solid fa-trash px-1 text-danger"></i>
                            </td>
                        </tr>
                        <?php
                        $sr++;
                    }
                    ?>
                </tbody>
            </table>
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
    <script src="../js/categories.js"></script>
</body>

</html>