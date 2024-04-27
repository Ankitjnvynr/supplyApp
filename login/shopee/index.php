<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/Exception.php';
require '../../phpmailer/PHPMailer.php';
require '../../phpmailer/SMTP.php';
session_start();

if (isset($_SESSION['loggedin']))
{
    header('location:../../');
    exit;
}
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
            <?php
            isset($_GET['signup']) ? include 'signup.php' : include 'login.php';
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../../js/login.js"></script>
</body>

</html>