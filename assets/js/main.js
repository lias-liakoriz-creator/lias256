document.addEventListener('DOMContentLoaded', function () {
    // Form validation
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            const inputs = form.querySelectorAll('input[type="text"], select');
            let valid = true;

            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    valid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '';
                }
            });

            if (!valid) {
                event.preventDefault();
                alert('Please fill in all fields.');
            }
        });
    });

    // Dynamic language selection (example)
    const languageSelect = document.getElementById('language');
    if (languageSelect) {
        languageSelect.addEventListener('change', function () {
            alert(`Language selected: ${languageSelect.value}`);
        });
    }
});
