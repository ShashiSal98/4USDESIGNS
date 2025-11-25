document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const loadingDiv = form.querySelector('.loading');
    const errorDiv = form.querySelector('.error-message');
    const successDiv = form.querySelector('.sent-message');

    // Hide messages initially
    loadingDiv.style.display = "none";
    errorDiv.style.display = "none";
    successDiv.style.display = "none";

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        // Reset messages
        loadingDiv.style.display = "block";
        errorDiv.style.display = "none";
        successDiv.style.display = "none";

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(async response => {
            loadingDiv.style.display = "none";

            if (response.ok) {
                // ✅ Email sent successfully
                successDiv.style.display = "block";
                form.reset();
            } else {
                // ❌ Error from Formspree
                const data = await response.json();
                errorDiv.textContent = data.errors
                    ? data.errors.map(e => e.message).join(", ")
                    : "Message failed to send.";
                errorDiv.style.display = "block";
            }
        })
        .catch(error => {
            // ❌ Network/JS error
            loadingDiv.style.display = "none";
            errorDiv.textContent = "An error occurred. Please try again.";
            errorDiv.style.display = "block";
            console.error(error);
        });
    });
});
