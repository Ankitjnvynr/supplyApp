

const emailToast = document.getElementById('emailToast')
const emailToastShow = bootstrap.Toast.getOrCreateInstance(emailToast)

// Initialize EmailJS with your user ID
emailjs.init("y6h-t_BnDBEgh4v-k");
// Function to send verification email
async function sendVerificationEmail(email, otp) {

    emailjs.send("service_0hj770c", "template_n3ebbni", {
        to: email,
        from: "ankitbkana@outlook.com",
        subject: "Verification Code",
        otp: "Your OTP: " + otp,
        email:email
    }).then(function (response) {
        console.log("Email sent successfully", response);
        $('#emailSendBtn').html('Next >')
        emailToastShow.show()
        $('#otpForm').removeAttr('hidden');
        $('#emailForm').remove();
        // form.submit()
    }, function (error) {
        $('#emailSendBtn').html('Error! try again')
        console.error("Email sending failed", error);
    });
}

// Function to generate OTP
function generateOTP() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: 'generateOTP.php',
            type: 'POST',
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}


(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                $('#emailmsg').html('')
                event.preventDefault()
                event.stopPropagation()
            } else {
                let emailForm = document.getElementById('emailForm')
                if (emailForm) {
                    event.preventDefault();
                    emailSending();
                }
            }

            form.classList.add('was-validated')

        }, false)
    })
})()

// handling submit form 
emailSending = async () => {
    // checking the email exist or not via ajax
    email = document.getElementById('userEmail');
    try {
        const response = await $.ajax({
            url: 'checkExist.php',
            type: 'POST',
            data: { userEmail: email.value }
        })
        if (response == '1') {
            $('#emailmsg').html('Email Already Exist')
        } else {
            $('#emailSendBtn').html(`<div class="spinner-grow spinner-grow-sm text-light" role="status"><span class="visually-hidden">Loading...</span> </div> Please Wait...`);
            $('#emailmsg').html('');
            const otp = await generateOTP();
            await sendVerificationEmail(email.value, otp)
        }
    } catch (error) {
        console.error("email not sent", error)
    }
}





