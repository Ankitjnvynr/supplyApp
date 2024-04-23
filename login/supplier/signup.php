<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$emailSend = false;

session_start(); // Start the session

// Function to generate OTP
function generateOTP()
{
    return rand(100000, 999999);
}

$step1 = true;
$step2 = false;

if (isset($_POST['userEmail']) && isset($_POST['Next']))
{
    echo $_POST['Next'];
    $userEmail = $_POST['userEmail'];
    $_SESSION['userEmail'] = $userEmail;
    // Generate and store OTP in session
    $_SESSION['otp'] = generateOTP();

    $mail->isSMTP();
    $mail->Host = 'smtp-mail.outlook.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ankitbkana@outlook.com';
    $mail->Password = 'ankit1558';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('ankitbkana@outlook.com', 'Delever Goods');
    $mail->addAddress($_SESSION['userEmail'], 'Recipient Name');

    $mail->Subject = 'OTP Varification';
    $mail->Body = 'Your 6 digit varification code is ' . $_SESSION['otp'];

    //sendig email by try catch 
    try
    {
        $mail->send();
        $emailSend = true;
    } catch (Exception $e)
    {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    $step1 = false;
    $step2 = true;
}
?>



<form class="shadow p-3 rounded needs-validation" novalidate method="POST" action="">
    <div class="text-center mb-3">
        <h4>Sign Up</h4>
    </div>
    <div class="mb-3" <?php echo $step1 ? '' : 'hidden' ?>>
        <label for="userEmail" class="form-label">Email address</label>
        <input autocomplete="off" type="email" class="form-control" id="userEmail" name="userEmail"
            aria-describedby="emailHelp" value="<?php echo isset($_POST['userEmail']) ? $_POST['userEmail'] : '' ?>"
            required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        <div class="invalid-feedback">
            Please enter a valid email.
        </div>
    </div>
    <div class="my-2 text-muted fs-6" <?php echo $step2 ? '' : 'hidden' ?>>
        <p class="fs-6">Check OTP on <span
                class="text-success"><?php echo isset($_POST['userEmail']) ? $_POST['userEmail'] : '' ?></span></p>
    </div>
    <div class="mb-3" <?php echo $step2 ? '' : 'hidden' ?>>
        <label for="userPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="userPassword" name="userPassword" <?php echo $step2 ? 'required' : 'hidden' ?>>
    </div>
    <div class="mb-3" <?php echo $step2 ? '' : 'hidden' ?>>
        <label for="userConfirmPassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="userConfirmPassword" name="userConfirmPassword" <?php echo $step2 ? 'required' : 'hidden' ?>>
    </div>
    <div class="mb-3" <?php echo $step2 ? '' : 'hidden' ?>>
        <label for="userOtp" class="form-label">OTP</label>
        <input type="number" class="form-control" minlength="6" maxlength="6" id="userOtp" name="userOtp" <?php echo $step2 ? 'required' : 'hidden' ?>>
    </div>
    <div class="mb-3 form-check" hidden>
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>

    <div class="text-center">
        <button type="submit" name="<?php echo $step1 ? 'Next' : 'Signup' ?>" class="btn btn-success text-center"
            fdprocessedid="vw48xs" style="width: 100%;"><?php echo $step1 ? 'Next ->' : 'Signup' ?></button>
    </div>
</form>
<?php
if ($emailSend)
    echo `<script>
                const emailToast = document.getElementById('emailToast')
                const emailToastOK = bootstrap.Toast.getOrCreateInstance(emailToast)
                emailToastOK.show() 
                </script>`;
?>

<script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>