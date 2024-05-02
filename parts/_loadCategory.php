<option value="" selected>Category</option>
<?php
require_once '../partials/_db.php';
$catSql = "SELECT * FROM `categories`";
$result = $conn->query($catSql);
while ($row = $result->fetch_assoc())
{
    echo '<option value="' . $row['cat_name'] . '" >' . $row['cat_name'] . '</option>';
}
?>