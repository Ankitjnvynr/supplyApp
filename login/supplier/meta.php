<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('location:../../');
    exit;
}

require_once '../../partials/_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Collect data from the form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $city = $_POST['city'];
    $pin_code = $_POST['pin_code'];
    $shop_name = $_POST['shop_name'];

    $_SESSION['userEmail'];
    // SQL update query
    $sql = "UPDATE users SET name=?, phone=?, state=?, district=?, tehsil=?, city=?, pin_code=?, shop_name=? WHERE email=?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt)
    {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssssssss", $name, $phone, $state, $district, $tehsil, $city, $pin_code, $shop_name, $_SESSION['userEmail']);

        if ($stmt->execute())
        {
            echo "User data updated successfully";
            echo $loginEmail = $_SESSION['userEmail'];
            // session_destroy();
            // Unset all session variables
            foreach (array_keys($_SESSION) as $key)
            {
                unset($_SESSION[$key]);
            }
            $data = array(
                'userEmail' => $loginEmail,
            );
            $getid = "SELECT * FROM `users` WHERE email = '$loginEmail'";
            $respon = $conn->query($getid);
            while($userid = mysqli_fetch_assoc($respon)){
                $_SESSION['userId'] = $userid['id'];
                $_SESSION['userType'] = $userid['user_type'];
            }
            $_SESSION['userEmail']=$loginEmail;
            $_SESSION['loggedin'] = true;
            $_SESSION['userName'] = $name;
            
            header("location: ../handlelogin.php");
            exit;
        } else
        {
            echo "Error updating user data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else
    {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deliver:login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/app.css">
    <link rel="stylesheet" href="../../css/login.css">
</head>

<body>
    <div class="main container">
        <!-- toast notification start -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="emailToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="https://cliply.co/wp-content/uploads/2021/03/372103860_CHECK_MARK_400px.gif"
                        class="rounded me-2" alt="...">
                    <strong class="me-auto">Email</strong>
                    <small>0 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    OTP send to your email.
                </div>
            </div>
        </div>
        <!-- toast notification end -->

        <div class="choose-user-type-box d-flex gap-4 flex-column align-items-center justify-content-center ">
            <form class="w-100 rounded shadow p-2" action="" method="POST">
                <p class="mb-1 text-success text-center">Fill the information below :</p>
                <div class="mb-3">
                    <label for="name" class="form-label-sm">Name</label>
                    <input class="form-control form-control-sm" id="name" name="name" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label-sm">Phone</label>
                    <input class="form-control form-control-sm" id="phone" name="phone" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label-sm">State</label>
                    <input class="form-control form-control-sm" id="state" name="state" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="district" class="form-label-sm">District</label>
                    <input class="form-control form-control-sm" id="district" name="district" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="tehsil" class="form-label-sm">Tehsil</label>
                    <input class="form-control form-control-sm" id="tehsil" name="tehsil" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label-sm">City/Village</label>
                    <input class="form-control form-control-sm" id="city" name="city" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="pin_code" class="form-label-sm">Pin Code</label>
                    <input class="form-control form-control-sm" id="pin_code" name="pin_code" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <div class="mb-3">
                    <label for="shop_name" class="form-label-sm">Shop Name</label>
                    <input class="form-control form-control-sm" id="shop_name" name="shop_name" type="text"
                        aria-label=".form-control-sm example" required>
                </div>
                <button type="submit" style="width: 100%;" class="btn btn-success text-center">Create Account</button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../../js/login.js"></script>
</body>

</html>