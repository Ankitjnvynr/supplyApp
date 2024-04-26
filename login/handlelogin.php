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
                    header('location:supplier/meta.php');
                    exit;
                }
                else{
                    header('location:../');
                    exit;
                    // echo $name = $row['name'];
                    // echo $phone = $row['phone'];
                    // echo $state = $row['state'];
                    // echo $district = $row['district'];
                    // echo $tehsil = $row['tehsil'];
                    // echo $city = $row['city'];
                    // echo $pin_code = $row['pin_code'];
                    // echo $shop_name = $row['shop_name'];

                }

            }
        }
    }

    // header('location: ../../');
}
?>