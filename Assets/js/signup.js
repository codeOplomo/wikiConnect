const form = document.getElementById('signup-form');

form.addEventListener('submit', function (event) {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach((element) => {
        element.textContent = '';
    });

    let isValid = true;

    const username = document.getElementById('username');
    const phone = document.getElementById('phone');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

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

    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone.value.trim())) {
        document.getElementById('phone-error').textContent = 'Phone number must be 10 digits.';
        isValid = false;
    }

    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email.value.trim())) {
        document.getElementById('email-error').textContent = 'Invalid email format.';
        isValid = false;
    }

    if (password.value.trim().length < 8) {
        document.getElementById('password-error').textContent = 'Password must be at least 8 characters.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});




