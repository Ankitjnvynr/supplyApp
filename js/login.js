

// Fetch the form
const form = document.querySelector('.needs-validation')[0];

// Initialize EmailJS with your user ID
emailjs.init("y6h-t_BnDBEgh4v-k");
// Function to send verification email
function sendVerificationEmail(email, otp) {
    emailjs.send("service_0hj770c", "template_n3ebbni", {
        to: email,
        from: "ankitbkana@outlook.com",
        subject: "Verification Code",
        otp: "Your OTP: " + otp
    }).then(function (response) {
        console.log("Email sent successfully", response);
        form.submit()
    }, function (error) {
        console.error("Email sending failed", error);
    });
}

// Function to generate OTP
function generateOTP() {
    return new Promise(function (resolve, reject) {
        // Generate OTP code here
        const otp = Math.floor(100000 + Math.random() * 900000);
        if (otp) {
            resolve(otp); // Resolve the promise with OTP
        } else {
            reject(new Error('Failed to generate OTP')); // Reject the promise if OTP generation fails
        }
    });
}



// Add event listener for form submission
form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!form.checkValidity()) {
        event.stopPropagation();
    } else {
        // Form is valid, proceed with sending email
        const userEmail = document.getElementById('userEmail').value;
        generateOTP().then(async function (userOtp) {
            await sendVerificationEmail(userEmail, userOtp);
            // Proceed with form submission
        }).catch(function (error) {
            console.error('Error generating OTP:', error);
        });
    }

    form.classList.add('was-validated');
}, false);





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