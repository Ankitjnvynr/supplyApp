<?php
require_once '../partials/_db.php';
session_start();
echo $userEmail = $_SESSION['userEmail'];
if (isset($_SESSION['loggedin']))
{
    echo $userEmail = $_SESSION['userEmail'];

    $sql = "SELECT * FROM `users` WHERE email = '$userEmail' ";
    $res = $conn->query($sql);
    if ($res)
    {
        $nums = $res->num_rows;
        if ($nums > 0)
        {
            echo "dfs";
            while ($row = mysqli_fetch_assoc($res))
            {
                if (empty($row['name']) || empty($row['phone']) || empty($row['state']) || empty($row['district']) || empty($row['tehsil']) || empty($row['city']) || empty($row['pin_code']) || empty($row['shop_name']))
                {
                    echo "One or more required fields are blank or null.";
                    if ($_SESSION['userType'] == 'supplier') {
                        header('location:supplier/meta.php');
                    } else {
                        header('location:shopee/meta.php');
                    }
                    
                    exit;
                } else {
                    $_SESSION['userID'] = $row['id'];
                    $_SESSION['userName'] = $row['name'];
                    if ($_SESSION['userType'] == 'supplier') {
                        header('location:../supplier');
                    } else {
                        header('location:../shopee');
                    }
                    
                    exit;
                }

            }
        }
    }

    // header('location: ../../');
}
?>