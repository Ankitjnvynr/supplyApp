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
$whereClause = ' WHERE shopee_id = ?';
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

if ($res->num_rows > 0)
{
    while ($row = $res->fetch_assoc())
    {
        // Fetching supplier details
        $supplier_id = $row['supplier_id'];
        $supplierStmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $supplierStmt->bind_param('i', $supplier_id);
        $supplierStmt->execute();
        $supplierResult = $supplierStmt->get_result();
        $supplierRow = $supplierResult->fetch_assoc();

        $Supplier_name = htmlspecialchars($supplierRow['name']);
        $Supplier_store_name = htmlspecialchars($supplierRow['shop_name']);
        $Supplier_phone = htmlspecialchars($supplierRow['phone']);
        ?>
        <div class="orderBox mt-2 p-1 px-2 border border-success-subtle">
            <div class="d-flex justify-content-between">
                <p class="fs-7 m-0 fw-semibold text-muted">
                    ORDER ID:<span class="text-success"><?php echo htmlspecialchars($row['order_id']); ?></span>
                </p>
                <p class="fs-7 m-0 fw-semibold text-muted opacity-50">
                    <?php echo htmlspecialchars($row['dt']); ?>
                </p>
            </div>
            <p class="fs-5 fw-bold m-0">
                <?php echo $Supplier_store_name; ?>
                <a class="fs-7 text-success text-decoration-none" >
                    (<?php echo ucfirst($Supplier_name); ?>) 
                </a>
            </p>
            <p class="m-0 fs-7 text-muted">You Ordered: Pensil, Erasor, Oyes, .....</p>
            <div class="d-flex gap-1">
                <a class="fs-4 shadow-sm rounded-pill px-2 text-success text-decoration-none "
                    href="tel:<?php echo $Supplier_phone ?>">
                    <i class="fa-solid fa-phone-volume"></i>
                </a>
                <a class="fs-4 px-2 shadow-sm rounded-pill text-success text-decoration-none"
                    href="https://wa.me/91<?php echo $Supplier_phone."?text=Hi, ". ucfirst($Supplier_name) ?>  ">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <a href="order.php?order=<?php echo htmlspecialchars($row['order_id']); ?>"
                    class="flex-item-btn btn btn-success fs-7 m-1 rounded-pill p-1">
                    <i class="fa-brands fa-readme"></i> View Order
                </a>
                <button onclick="deleteOrder(this, <?php echo $row['id']; ?>)" type="button"
                    class="flex-item-btn btn btn-outline-danger fs-7 m-1 rounded-pill p-1">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </div>
        <?php
    }
} else
{
    echo '<div class="text-center text-muted mt-5">No order found</div>';
}
?>