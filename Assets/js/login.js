const form = document.querySelector('form');
const loginError = document.getElementById('login-error');

form.addEventListener('submit', function (event) {
    // Clear previous error messages
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach((element) => {
        element.textContent = '';
    });

    let isValid = true;

    // Validation logic here
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    // Email validation: Regex for a simple email format (customize as needed)
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email.value.trim())) {
        document.getElementById('email-error').textContent = 'Invalid email format.';
        isValid = false;
    }

    // Password validation: Minimum 8 characters (customize as needed)
    if (password.value.trim().length < 8) {
        document.getElementById('password-error').textContent = 'Password must be at least 8 characters.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if there are validation errors
        loginError.textContent = 'Please correct the errors and try again.';
    }
});
