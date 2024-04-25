<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../partials/_db.php';

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

$userOtpMsg = false;
$userPwdMsg = false;
$emailSend;

if (isset($_POST['userEmail']) && isset($_POST['Next']))
{
    
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
        $emailSend = 'OTP sent to <span class="text-success">' . $_SESSION['userEmail'] . '</span>';
    } catch (Exception $e)
    {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    $step1 = false;
    $step2 = true;
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
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            // Prepare the statement
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param("ss", $_SESSION['userEmail'], md5($userPassword));
                if ($stmt->execute()) {
                    // Redirect to step 2
                    header("Location: meta.php");
                    exit();
                } else {
                    echo "Error inserting record: " . $stmt->error;
                }
                // Close the statement
                $stmt->close();
            } else {
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
        $step1 = false;
        $step2 = true;
    }
}
?>

<form class="shadow p-3 rounded needs-validation" novalidate method="POST" action="">
    <div class="text-center mb-3">
        <h4>Sign Up</h4>
    </div>
    <div class="mb-3" <?php echo $step1 ? '' : 'hidden' ?>>
        <label for="userEmail" class="form-label">Email address</label>
        <input autocomplete="false" aria-autocomplete="false" type="email" class="form-control" id="userEmail" name="userEmail"
            aria-describedby="emailHelp" value="<?php echo isset($_POST['userEmail']) ? $_POST['userEmail'] : '' ?>"
            required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        <div class="invalid-feedback">
            Please enter a valid email.
        </div>
    </div>
    <div class="my-2 text-muted fs-6" <?php echo $step2 ? '' : 'hidden' ?>>
        <?php
        echo $emailSend;
        ?>
    </div>
    <div class="mb-3" <?php echo $step2 ? '' : 'hidden' ?>>
        <label for="userPassword" class="form-label">Password</label>
        <input autocomplete="off" aria-autocomplete="false" type="password" value="" class="form-control" id="userPassword" name="userPassword" <?php echo $step2 ? 'required' : 'hidden' ?>>
    </div>
    <div class="mb-3" <?php echo $step2 ? '' : 'hidden' ?>>
        <label for="userConfirmPassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="userConfirmPassword" name="userConfirmPassword" <?php echo $step2 ? 'required' : 'hidden' ?>>
        <span class="text-danger"><?php echo $userPwdMsg ?></span>
    </div>
    <div class="mb-3" <?php echo $step2 ? 'required' : 'hidden' ?>>
        <label for="userOtp" class="form-label">OTP</label>
        <input type="number" class="form-control" minlength="6" maxlength="6" id="userOtp" name="userOtp" <?php echo $step2 ? 'required' : 'hidden' ?>>
        <span class="text-danger"><?php echo $userOtpMsg ?> </span>
    </div>
    <div class="mb-3 form-check" hidden>
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>

    <div class="text-center">
        <button id="" type="submit" name="<?php echo $step1 ? 'Next' : 'Signup' ?>" class="btn btn-success text-center"
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
                    // var button = form.querySelector('button[type="submit"]');
                    // button.innerHTML = `
                    //     <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    // <span role="status">Sending OTP ...</span>
                    //     `;
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>