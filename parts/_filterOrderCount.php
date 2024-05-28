<?php
session_start();

if (!isset($_SESSION['loggedin']))
{
    header('Location: ../login/');
    exit;
}

require_once '../partials/_db.php';

// Error handling and sanitization (consider using prepared statements fully)
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

// Fetching session data
$user_id = $_SESSION['userId'];
$userEmail = $_SESSION['userEmail'];
$userName = $_SESSION['userName'];

// Retrieving POST parameters and basic sanitization
$searchbox = isset($_POST['searchbox']) ? filter_var($_POST['searchbox'], FILTER_SANITIZE_STRING) : '';
$category = isset($_POST['category']) ? filter_var($_POST['category'], FILTER_SANITIZE_STRING) : '';
$start_date = isset($_POST['start_date']) ? filter_var($_POST['start_date'], FILTER_SANITIZE_STRING) : '';
$end_date = isset($_POST['end_date']) ? filter_var($_POST['end_date'], FILTER_SANITIZE_STRING) : '';
$start = isset($_POST['start']) ? (int) $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 10;

// Constructing the WHERE clause
$whereClause = ' WHERE shopee_id = ?';
$params = [$user_id];
$types = 'i'; // Type for user_id

// Building the total orders SQL query
$sql = "SELECT COUNT(*) total_orders FROM `orders`" . $whereClause; // Use aliases for clarity

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_orders = (int) $row['total_orders'];


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
$sql = "SELECT COUNT(*) filtered_orders FROM `orders`" . $whereClause; // Use aliases for clarity

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Prepare JSON data
$data = [
    'total_orders' => $total_orders,
    'filtered_orders' => (int) $row['filtered_orders'],
];

// Close connection (consider using mysqli_stmt_close and mysqli_close)
$stmt->close();
$conn->close();

// Encode JSON and output
header('Content-Type: application/json');
echo json_encode($data);
