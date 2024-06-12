<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('Location: ../login/');
    exit;
}

require_once '../partials/_db.php';

// Fetching session data
$user_id = $_SESSION['userId'];
$userEmail = $_SESSION['userEmail'];
$userName = $_SESSION['userName'];

// Retrieving POST parameters and ensuring they are sanitized
$searchbox = isset($_POST['searchbox']) ? $_POST['searchbox'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$start = isset($_POST['start']) ? (int) $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 10;

// Constructing the WHERE clause
$whereClause = ' WHERE supplier_id = ?';
$params = [$user_id];
$types = 'i'; // Type for user_id

if (!empty($searchbox))
{
    $searchTerms = explode(' ', $searchbox);
    $whereClause .= ' AND (';
    $first = true;
    foreach ($searchTerms as $term)
    {
        if (!$first)
        {
            $whereClause .= ' OR ';
        }
        $whereClause .= "(order_id LIKE ? )";
        $params[] = '%' . $term . '%';
        // $params[] = '%' . $term . '%';
        $types .= 's';
        $first = false;
    }
    $whereClause .= ')';
}

if (!empty($category))
{
    $whereClause .= ' AND category = ?';
    $params[] = $category;
    $types .= 's';
}
// Adding date filter to the WHERE clause
if (!empty($start_date))
{
    $whereClause .= ' AND dt >= ?';
    $params[] = $start_date;
    $types .= 's';
}

if (!empty($end_date))
{
    $whereClause .= ' AND dt <= ?';
    $params[] = $end_date;
    $types .= 's';
}

// Building the final SQL query
$sql = "SELECT * FROM `orders`" . $whereClause . " ORDER BY id DESC LIMIT ?, ?";
$params[] = $start;
$params[] = $limit;
$types .= 'ii';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
$nums = $res->num_rows;
if ($nums > 0)
{
    while ($row = $res->fetch_assoc())
    {
        // fetching shopekeeper details 
        $supplier_id = $row['shopee_id'];
        $supplier = "SELECT * FROM `users` WHERE id = $supplier_id";
        $suppResult = $conn->query($supplier);
        $supplierRow = $suppResult->fetch_assoc();
        $Supplier_name = $supplierRow['name'];
        $Supplier_store_name = $supplierRow['shop_name'];
        $Supplier_phone = $supplierRow['phone'];
        ?>
        <div class=" orderBox  mt-2 p-1 px-2 border border-success-subtle">
            <div class="d-flex justify-content-between">
                <p class="fs-7 m-0 fw-semibold text-muted">
                    ORDER ID:<span class="text-success"><?php echo $row['order_id']; ?></span>
                </p>
                <p class="fs-7 m-0 fw-semibold text-muted opacity-50">
                    <?php echo $row['dt']; ?>
                </p>
            </div>
            <p class="fs-5 fw-bold m-0">
                <?php echo $Supplier_store_name ?> <a class="fs-7 text-success text-decoration-none"
                    href="tel:<?php echo $Supplier_phone ?>">(<?php echo ucfirst($Supplier_name) ?>) <i
                        class="fa-solid fa-phone"></i></a>
            </p>
            <div class="d-flex justify-content-between">
                <p class="m-0 fs-7 text-muted text-truncate">They Ordered:

                    <?php
$itemsSQL = "SELECT product_name FROM `order_items`WHERE order_id = '' "
                    ?>

                </p>
                <div class="form-check form-switch form-check-reverse border-top border-bottom border-success-subtle rounded ">
                    <input onchange="changeOrderStatus(this, <?php echo $row['order_id'] ?>)" class="form-check-input "
                        type="checkbox" id="flexSwitchCheckReverse" <?php echo $row['status'] == '1' ? 'checked' : '' ?>>
                    <label class="form-check-label fs-7" for="flexSwitchCheckReverse">Editable</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a class="fs-4 shadow rounded-pill px-2 text-success text-decoration-none "
                    href="tel:<?php echo $Supplier_phone ?>">
                    <i class="fa-solid fa-phone-volume"></i>
                </a>
                <a class="fs-4 px-2 shadow rounded-pill text-success text-decoration-none"
                    href="https://wa.me/91<?php echo $Supplier_phone ?>">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="order.php?order=<?php echo $row['order_id']; ?>"
                    class=" flex-item-btn btn btn-success fs-7 m-1 rounded-pill p-1"><i class="fa-brands fa-readme"></i> View
                    Order</a>
                <button onclick="deleteOrder(this, <?php echo $row['id'] ?>)" type="button"
                    class=" flex-item-btn btn btn-outline-danger fs-7 m-1 rounded-pill p-1"><i class="fa-solid fa-trash"></i>
                    Delete</button>

            </div>
        </div>
        <?php
    }
} else
{
    echo '<div class="text-center text-muted mt-5">No order found</div>';
}
?>