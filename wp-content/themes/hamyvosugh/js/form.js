document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 5;

    function showStep(step) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');

        document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
        document.querySelector(`.step[data-step="${step}"]`).classList.add('active');

        if (step === totalSteps) {
            updateReview();
        }
    }

    function validateInputs() {
        const currentInputs = document.querySelector(`.form-step[data-step="${currentStep}"]`).querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        currentInputs.forEach(input => {
            if (!input.value.trim()) {
                showErrorMessage(input, 'This field is required');
                isValid = false;
            } else if (input.type === 'email' && !validateEmail(input.value)) {
                showErrorMessage(input, 'Please enter a valid email address');
                isValid = false;
            } else {
                clearErrorMessage(input);
            }
        });
        return isValid;
    }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function showErrorMessage(input, message) {
        input.classList.add('input-error');
        const error = input.nextElementSibling || document.createElement('div');
        error.className = 'error-message';
        error.textContent = message;
        input.parentNode.insertBefore(error, input.nextSibling);
    }

    function clearErrorMessage(input) {
        input.classList.remove('input-error');
        if (input.nextElementSibling && input.nextElementSibling.classList.contains('error-message')) {
            input.nextElementSibling.remove();
        }
    }

    function updateReview() {
        const reviewInfo = document.querySelector('.review-info');
        reviewInfo.innerHTML = '';
        document.querySelectorAll('input, select, textarea').forEach(input => {
            if (input.value) {
                const div = document.createElement('div');
                div.textContent = `${input.name}: ${input.value}`;
                reviewInfo.appendChild(div);
            }
        });
    }

    document.querySelectorAll('.next-btn, .prev-btn').forEach(button => {
        button.addEventListener('click', function() {
            const direction = this.classList.contains('next-btn') ? 1 : -1;
            if (validateInputs() || direction < 0) {
                currentStep += direction;
                showStep(currentStep);
            }
        });
    });

    document.querySelector('#multistepForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateInputs()) {
            this.submit(); // All inputs are valid, proceed with form submission
        }
    });
});