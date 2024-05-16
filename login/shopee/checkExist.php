<?php
require_once '../../partials/_db.php';
$email = $_POST['userEmail'];
// Function to check if an email exists
$_SESSION['userEmail'] = $email;
$sql = "SELECT * FROM users WHERE email = '$email'";
$res = $conn->query($sql);
$nums = $res->num_rows;
if ($nums > 0)
{
    echo '1';
} else
{
    echo '0';
}

