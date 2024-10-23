document.querySelector('.login').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the default way

    var form = event.target;
    var formData = new FormData(form);

    // Send the form data to session.php using Fetch API
    fetch('session.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' || data.status === 'new_user') {
            // Redirect the user to the specified page
            window.location.href = data.redirect;
        } else if (data.status === 'error') {
            // Display error message below the password input
            var passwordField = document.getElementById('Password');
            var errorElement = document.querySelector('.error-message');

            if (!errorElement) {
                // Create the error message element if it doesn't exist
                errorElement = document.createElement('div');
                errorElement.classList.add('error-message');
                passwordField.insertAdjacentElement('afterend', errorElement);
            }

            errorElement.textContent = data.message; // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
