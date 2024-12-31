document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const steps = document.querySelectorAll('.form-step');
    const totalSteps = steps.length; // Dynamically determine the number of steps
    const navContainer = document.querySelector('.navigation-dots');

  // Function to create navigation dots
    function createNavDots() {
        for (let i = 0; i < totalSteps; i++) {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            dot.dataset.step = i + 1;
            navContainer.appendChild(dot);
        }
        updateNavDots();
    }

    // Function to update active dot based on current step
    function updateNavDots() {
        document.querySelectorAll('.dot').forEach(dot => {
            if (parseInt(dot.dataset.step) === currentStep) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }
    function showStep(step) {
        steps.forEach((el, index) => {
            el.classList.remove('active');
            if (index + 1 === step) { // steps are 1-based in your data attributes
                el.classList.add('active');
            }
        });

        document.querySelectorAll('.step').forEach((el, index) => {
            el.classList.remove('active');
            if (index + 1 === step) {
                el.classList.add('active');
            }
        });
    }

    function validateCurrentStep() {
        const currentFormStep = document.querySelector('.form-step.active');
        if (!currentFormStep) {
            console.log("No active form step found."); // Debugging
            return false;
        }

        const inputs = currentFormStep.querySelectorAll('input[required], select[required], textarea[required]');
        let valid = true;

        inputs.forEach(input => {
            if (!input.value.trim() && input.hasAttribute('required')) {
                showError(input, 'This field is required');
                valid = false;
            } else {
                clearError(input);
            }
        });

        const emailInput = currentFormStep.querySelector('input[type="email"]');
        if (emailInput && !validateEmail(emailInput.value)) {
            showError(emailInput, 'Invalid email address');
            valid = false;
        } else if (emailInput) {
            clearError(emailInput);
        }

        return valid;
    }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email.toLowerCase());
    }

    function showError(input, message) {
        let errorDiv = input.nextElementSibling;
        if (!errorDiv || errorDiv.className !== 'error-message') {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            input.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        input.classList.add('error');
    }

    function clearError(input) {
        const errorDiv = input.nextElementSibling;
        if (errorDiv && errorDiv.className === 'error-message') {
            input.parentNode.removeChild(errorDiv);
        }
        input.classList.remove('error');
    }

    function updateReviewStep() {
        const reviewDiv = document.querySelector('.review-info');
        const inputs = document.querySelectorAll('#multistepForm input, #multistepForm select, #multistepForm textarea');
        reviewDiv.innerHTML = '';

        inputs.forEach(input => {
            if (input.name && input.value) {
                const key = input.name.charAt(0).toUpperCase() + input.name.slice(1).replace('_', ' ');
                reviewDiv.innerHTML += `<p><strong>${key}:</strong> ${input.value}</p>`;
            }
        });

        if (reviewDiv.innerHTML === '') {
            reviewDiv.innerHTML = '<p>No data to display. Please go back and enter some information.</p>';
        }
    }

    document.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                    if (currentStep === totalSteps) {
                        updateReviewStep();
                    }
                }
            }
        });
    });

    document.querySelectorAll('.prev-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    document.getElementById('multistepForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateCurrentStep()) {
            this.submit();
        }
    });
});
