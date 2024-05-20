<?php
require_once '../partials/_db.php';

if (isset($_POST['id']) && isset($_POST['column']) && isset($_POST['value']))
{
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE order_items SET $column = ? WHERE id = ?");
    $stmt->bind_param('si', $value, $id);

    if ($stmt->execute())
    {
        echo 'success';
    } else
    {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else
{
    echo 'invalid';
}
?>
