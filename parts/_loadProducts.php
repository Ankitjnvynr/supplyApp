<hr class="m-1 p-0">
<?php
session_start();
require_once '../partials/_db.php';

$searchbox = isset($_POST['serachbox']) ? ($_POST['serachbox']) : ''; // Sanitize search term
$category = isset($_POST['category']) ? $_POST['category'] : ''; // Handle empty category
$start = isset($_POST['start']) ? (int) $_POST['start'] : 0; // Ensure integer for pagination
$limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 10; // Set default and ensure integer

$whereClause = ''; // Build WHERE clause dynamically

// Construct WHERE clause based on filters
if (!empty($searchbox))
{
    $searchTerms = explode(' ', $searchbox); // Split search terms for potential LIKE operator
    $whereClause .= ' WHERE (';
    $first = true;
    foreach ($searchTerms as $term)
    {
        if (!$first)
        {
            $whereClause .= ' OR ';
        }
        $whereClause .= "product_name LIKE '%$term%' OR category LIKE '%$term%'";
        $first = false;
    }
    $whereClause .= ')';
}

if (!empty($category))
{
    if (!empty($whereClause))
    {
        $whereClause .= ' AND ';
    } else
    {
        $whereClause .= ' WHERE ';
    }
    $whereClause .= "category = '$category'";
}

// Build the final SQL query
$sql = "SELECT * FROM `products`";
$sql .= $whereClause;
$sql .= " ORDER BY id DESC LIMIT $start, $limit";  // Apply pagination

$result = $conn->query($sql);
if ($result->num_rows > 0)
{
    while ($row = $result->fetch_assoc())
    {
        $pid = $row['id'];
        ?>
        <div class="productitem p-1 mt-2 text-muted shadow-sm shadow-success rounded">
            <div class="row ">
                <div class="col-10">
                    <div class="d-flex align-items-center">
                        <div id="pname<?php echo $pid; ?>" class="text-success fw-semibold"><?php echo $row['product_name'] ?>
                        </div>
                        <div class="fw-normal text-muted fs-7">
                            (
                        </div>
                        <div id="pcat<?php echo $pid; ?>" class="fw-normal text-muted fs-7"><?php echo $row['category'] ?></div>
                        <div class="fw-normal text-muted fs-7">
                            )
                        </div>
                    </div>
                    <div class="row fs-7">
                        <div class="col">
                            <i class="fa-solid fa-campground"></i>
                            <span id="pbrand<?php echo $pid; ?>"><?php echo $row['brand'] ?></span>
                        </div>
                        <div class="col fw-semibold">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                            <span id="pprice<?php echo $pid; ?>"><?php echo $row['price'] ?></span>
                        </div>
                        <div class="col">
                            <i class="fa-solid fa-cubes-stacked"></i>
                            <span id="pqty<?php echo $pid; ?>"><?php echo $row['qty'] ?></span>
                        </div>
                    </div>
                </div>
                <?php
                if ($_SESSION['userType'] == 'supplier')
                {
                    ?>
                    <div class="col-1 fs-4 d-flex flex-column gap-2 px-1">
                        <i onclick="openUpdateModal(this,<?php echo $row['id'] ?>)"
                            class="fa-solid fa-pen-to-square text-success"></i>
                        <i onclick="openDelModal(<?php echo $pid; ?>, this)" class="fa-solid fa-trash text-danger"></i>
                    </div>
                    <?php
                } else
                {
                    ?>
                    <div class="col-2 fs-7 d-flex flex-column gap-1 px-1">
                        <input class="form-control m-0 p-0 px-2 fs-7" type="number" id="quantity" name="quantity" value="1" min="1">
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Add to Order" class="btn btn-success m-0 p-0" id="addToCart"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                    <?php
                }

                ?>
                
            </div>
        </div>
        <?php
    }
} else
{
    echo '<div class="text-center text-muted"> No Products Found</div>';

}

?>