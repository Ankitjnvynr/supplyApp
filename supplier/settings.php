<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('location: ../login/');
} else {
    $_SESSION['loggedin'];
    $_SESSION['userId'];
    $_SESSION['userEmail'];
    $_SESSION['userName'];
}
$activeMenu = 'settings';
require_once '../partials/_db.php';



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updaeProfileInfo'])) {
    // Collect data from the form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $city = $_POST['city'];
    $pin_code = $_POST['pin_code'];
    $shop_name = $_POST['shop_name'];

    // Retrieve user's email from session
    $userEmail = $_SESSION['userEmail'];

    // SQL update query
    $sql = "UPDATE users SET name=?, phone=?, state=?, district=?, tehsil=?, city=?, pin_code=?, shop_name=? WHERE email=?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssssssss", $name, $phone, $state, $district, $tehsil, $city, $pin_code, $shop_name, $userEmail);

        if ($stmt->execute()) {
            // echo "User data updated successfully";
            // Update session variables if needed
            $_SESSION['userName'] = $name;
            // Redirect to a new page after updating

        } else {
            echo "Error updating user data: " . $stmt->error;
        }
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome:</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>

    <div class="main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>

        <div style="height:80%" class="d-flex flex-column justify-content-between">
            <div class=" " id="shopeeinfo"></div>
            <div class="d-flex gap-3 container ">
                <!-- <a href="#"><i class="fa-solid fa-camera text-muted"></i></a> -->
                <a class=" btn btn-outline-danger d-flex gap-1 text-decoration-none align-items-center" href="../login/logout.php"><span class="fw-bold">Logout</span><i class="fa-solid fa-right-from-bracket  fs-5"></i></a>
            </div>
        </div>

        <?php
        include '../partials/_footer.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/settings.js"></script>

</body>

</html>