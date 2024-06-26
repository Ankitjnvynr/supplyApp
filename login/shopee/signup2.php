<?php

require_once '../../partials/_db.php';


$emailSend = false;

// Function to generate OTP
function generateOTP()
{
    return rand(100000, 999999);
}


if (isset($_POST['userPassword']) && isset($_POST['userConfirmPassword']) && isset($_POST['userOtp']) && isset($_POST['Signup']))
{
    // $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];
    $userConfirmPassword = $_POST['userConfirmPassword'];
    $userOtp = $_POST['userOtp'];

    if ($userOtp == $_SESSION['otp'] && isset($_POST['userPassword']))
    {
        if ($userPassword == $userConfirmPassword)
        {
            $userType = 'shopee';
            $sql = "INSERT INTO users (email, password,user_type) VALUES (?, ?,?)";
            // Prepare the statement
            $hash = md5($userPassword);
            $email = $_SESSION['userEmail'];
            $stmt = $conn->prepare($sql);
            if ($stmt)
            {
                // Bind parameters and execute the statement
                $stmt->bind_param("sss", $email, $hash, $userType);
                if ($stmt->execute())
                {
                    $_SESSION['loggedin'] = true;
                    // Redirect to step 2
                    header("Location: meta.php");
                    exit();
                } else
                {
                    echo "Error inserting record: " . $stmt->error;
                }
                // Close the statement
                $stmt->close();
            } else
            {
                echo "Error preparing statement: " . $conn->error;
            }
        } else
        {
            $userPwdMsg = '<span class="text-danger">Passwords not match';
            $step1 = false;
            $step2 = true;
        }
    } else
    {
        $userOtpMsg = '<span class="text-danger">Wrong! OTP. Check again';
    }
}
?>

<form id="emailForm" class="shadow p-3 rounded needs-validation" novalidate method="POST" action="">
    <div class="text-center mb-3">
        <h4 class="text-success">Sign Up</h4>
    </div>
    <div class="mb-3">
        <label for="userEmail" class="form-label">Email address</label>
        <input autocomplete="false" aria-autocomplete="false" type="email" class="form-control" id="userEmail"
            name="userEmail" aria-describedby="emailHelp" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        <div id="emailmsg" class="text-danger fs-7"></div>
        <div class="invalid-feedback">
            Please enter a valid email.
        </div>
    </div>
    <div class="text-center">
        <button type="submit" id="emailSendBtn" name="Next" class="btn btn-success text-center" fdprocessedid="vw48xs"
            style="width: 100%;">Next -></button>
    </div>
    <p class="m-0 mt-3">Already an Account ? <a class="text-success fw-bold p-0 m-0" href="../supplier/">LogIn </a></p>
</form>

<form id="otpForm" class="shadow p-3 rounded " novalidate method="POST" action="" hidden>
    <div class="text-center mb-3">
        <h4 class="text-success">Sign Up</h4>
    </div>
    <div class="mb-3">
        <label for="userPassword" class="form-label">Password</label>
        <input autocomplete="false" aria-autocomplete="false" type="password" class="form-control" id="userPassword"
            name="userPassword" required>
        <div class="invalid-feedback">Please Enter Password.</div>
    </div>
    <div class="mb-3">
        <label for="userPassword" class="form-label">Confirm Password</label>
        <input autocomplete="false" aria-autocomplete="false" type="password" class="form-control"
            id="userConfirmPassword" name="userConfirmPassword" required>
        <div class="invalid-feedback">Please Enter Confirm Password.</div>
    </div>
    <div class="mb-3">
        <label for="userPassword" class="form-label">OTP</label>
        <input autocomplete="false" minlength="6" maxlength="6" aria-autocomplete="false" type="number"
            class="form-control" id="userOtp" name="userOtp" required>
        <div class="invalid-feedback">Please Enter your OTP</div>
    </div>
    <div class="text-center">
        <button type="submit" name="Signup" class="btn btn-success text-center" fdprocessedid="vw48xs"
            style="width: 100%;">Sign Up</button>
    </div>
    <p class="m-0 mt-3">Already an Account ? <a class="text-success fw-bold p-0 m-0" href="../supplier/">LogIn </a></p>
</form>






<?php
if ($emailSend)
    echo `<script>
                const emailToast = document.getElementById('emailToast')
                const emailToastOK = bootstrap.Toast.getOrCreateInstance(emailToast)
                emailToastOK.show() 
                </script>`;
?>