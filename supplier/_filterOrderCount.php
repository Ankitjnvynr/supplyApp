<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location: ../login/');
    exit;
} else
{
    $user_id = $_SESSION['userId'];
}

require_once '../partials/_db.php';

$searchbox = isset($_POST['searchbox']) ? $_POST['searchbox'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';


// Constructing the WHERE clause
$whereClause = ' WHERE supplier_id = ?';
$params = [$user_id];
$types = 'i'; // Type for user_id

// Adding search box filter to the WHERE clause
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
        $whereClause .= "order_id LIKE ?";
        $params[] = '%' . $term . '%';
        $types .= 's';
        $first = false;
    }
    $whereClause .= ')';
}

// Adding category filter to the WHERE clause
if (!empty($category))
{
    $whereClause .= ' AND category = ?';
    $params[] = $category;
    $types .= 's';
}

// Adding date filters to the WHERE clause
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

// Building the total orders SQL query
$totalSql = "SELECT COUNT(*) AS total_orders FROM `orders` WHERE supplier_id = ?";
$totalStmt = $conn->prepare($totalSql);
$totalStmt->bind_param('i', $user_id);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$total_orders = (int) $totalRow['total_orders'];
$totalStmt->close();

// Building the filtered orders SQL query
$filteredSql = "SELECT COUNT(*) AS filtered_orders FROM `orders`" . $whereClause;
$filteredStmt = $conn->prepare($filteredSql);
$filteredStmt->bind_param(str_repeat('s', count($params)), ...$params);
$filteredStmt->execute();
$filteredResult = $filteredStmt->get_result();
$filteredRow = $filteredResult->fetch_assoc();
$filtered_orders = (int) $filteredRow['filtered_orders'];
$filteredStmt->close();
$conn->close();

// Prepare JSON data
$data = [
    'total_orders' => $total_orders,
    'filtered_orders' => $filtered_orders,
];

// Encode JSON and output
header('Content-Type: application/json');
echo json_encode($data);
?>