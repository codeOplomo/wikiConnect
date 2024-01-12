const form = document.getElementById('signup-form');

form.addEventListener('submit', function (event) {
    // Clear previous error messages
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach((element) => {
        element.textContent = '';
    });

    let isValid = true;

    // Validation logic here
    const username = document.getElementById('username');
    const phone = document.getElementById('phone');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    // Check if input fields are empty and set error messages
    if (username.value.trim() === '') {
        document.getElementById('username-error').textContent = 'Username is required.';
        isValid = false;
    }

    if (phone.value.trim() === '') {
        document.getElementById('phone-error').textContent = 'Phone number is required.';
        isValid = false;
    }

    if (email.value.trim() === '') {
        document.getElementById('email-error').textContent = 'Email is required.';
        isValid = false;
    }

    if (password.value.trim() === '') {
        document.getElementById('password-error').textContent = 'Password is required.';
        isValid = false;
    }

    // Phone validation: 10 digits
    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone.value.trim())) {
        document.getElementById('phone-error').textContent = 'Phone number must be 10 digits.';
        isValid = false;
    }

    // Email validation: Regex for a simple email format (customize as needed)
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email.value.trim())) {
        document.getElementById('email-error').textContent = 'Invalid email format.';
        isValid = false;
    }

    // Password validation: Minimum 8 characters
    if (password.value.trim().length < 8) {
        document.getElementById('password-error').textContent = 'Password must be at least 8 characters.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if there are validation errors
    }
});




