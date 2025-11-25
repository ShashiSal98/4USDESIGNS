// review.js
document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('.php-email-form');

  forms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const loading = form.querySelector('.loading');
      const errorMsg = form.querySelector('.error-message');
      const successMsg = form.querySelector('.sent-message');

      // Reset state
      loading.style.display = 'block';
      errorMsg.style.display = 'none';
      successMsg.style.display = 'none';

      const formData = new FormData(form);

      fetch(form.action, {
        method: form.method,
        body: formData,
        headers: { 'Accept': 'application/json' }
      })
        .then(response => response.json())
        .then(data => {
          loading.style.display = 'none';

          if (data.ok) {
            // ✅ Success
            successMsg.style.display = 'block';
            form.reset();
          } else {
            // ❌ Formspree errors
            errorMsg.textContent = data.errors
              ? data.errors.map(e => e.message).join(', ')
              : 'Review submission failed. Please try again.';
            errorMsg.style.display = 'block';
          }
        })
        .catch(error => {
          loading.style.display = 'none';
          errorMsg.textContent = 'An error occurred. Please try again.';
          errorMsg.style.display = 'block';
          console.error(error);
        });
    });
  });
});
