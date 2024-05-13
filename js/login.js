
// Initialize EmailJS with your user ID
emailjs.init("y6h-t_BnDBEgh4v-k");
// Function to send verification email
function sendVerificationEmail(email, otp) {
    emailjs.send("service_0hj770c", "template_n3ebbni", {
        to: email,
        from: "ankitbkana@outlook.com",
        subject: "Verification Code",
        text: "Your OTP: " + otp
    }).then(function (response) {
        console.log("Email sent successfully", response);
    }, function (error) {
        console.error("Email sending failed", error);
    });
}

// geeratng otp 
function generateOTP() {
    // Declare a string to store the OTP
    let otp = "";

    // Loop to generate 6 random digits
    for (let i = 0; i < 6; i++) {
        // Generate a random number between 0 and 9
        const digit = Math.floor(Math.random() * 10);
        // Append the digit as a string to the OTP
        otp += digit.toString();
    }

    // Return the generated 6-digit OTP
    return otp;
}

// Fetch the form
const form = document.querySelector('.needs-validation');

// Add event listener for form submission
form.addEventListener('submit', function (event) {
    if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    } else {
        // Form is valid, proceed with sending email
        const userEmail = document.getElementById('userEmail').value;
        const userOtp = generateOTP(); // Assume you have a function to generate OTP
        sendVerificationEmail(userEmail, userOtp);
        // Proceed with form submission
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