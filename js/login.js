


const emailExistToast = document.getElementById('emailExistToast')
const emailToastExist = bootstrap.Toast.getOrCreateInstance(emailExistToast)

// Initialize EmailJS with your user ID
emailjs.init("y6h-t_BnDBEgh4v-k");
// Function to send verification email
async function sendVerificationEmail(email,otp) {
    console.log(otp)
    emailjs.send("service_0hj770c", "template_n3ebbni", {
        to: email,
        from: "ankitbkana@outlook.com",
        subject: "Verification Code",
        otp: "Your OTP: " + otp
    }).then(function (response) {
        console.log("Email sent successfully", response);
        // form.submit()
    }, function (error) {
        console.error("Email sending failed", error);
    });
}

// Function to generate OTP
function generateOTP() {
    return new Promise(function (resolve, reject) {
        // Generate OTP code here
        var otp;
        $.ajax({
            url: 'generateOTP.php',
            type: 'POST',
            success: function (response) {
                console.log(response);
                otp = response;
            }
        })

        resolve(otp); // Resolve the promise with OTP

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
                // var button = form.querySelector('button[type="submit"]');
                // button.innerHTML = `
                //     <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                // <span role="status">Sending OTP ...</span>
                //     `;
            } else {
                event.preventDefault();
                console.log("i am in pre");
                emailSending();
            }

            form.classList.add('was-validated')

        }, false)
    })
})()

// handling submit form 
emailSending = async (form) => {
    // checking the email exist or not via ajax
    email = document.getElementById('userEmail');
    $.ajax({
        url: 'checkExist.php',
        type: 'POST',
        data: { userEmail: email.value },
        success: function (response) {
            if (response == '1') {
                $('#emailmsg').html('Email Already Exist')
            } else {
                $('#emailmsg').html('');
                otp = generateOTP()
                sendVerificationEmail(email,otp );

            }

        }
    })
}


// const emailToast = document.getElementById('emailToast')
// const emailToastShow = bootstrap.Toast.getOrCreateInstance(emailToast)


