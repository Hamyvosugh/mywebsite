<?php
/**
 * Template Name: Multi Step Form
 */

// Enqueue styles
function custom_multistep_form_shortcode() {
    ob_start();
    $file_path = get_template_directory() . '/multistep-form-template.php';
    echo $file_path;  // This will output the path to help you debug
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo "File not found.";
    }
    return ob_get_clean();
}
add_shortcode('custom_multistep_form', 'custom_multistep_form_shortcode');

// Form processing
function handle_form_submission() {
    if (isset($_POST['form_submit'])) {
        $errors = [];
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $address = sanitize_text_field($_POST['address'] ?? '');
        $service = sanitize_text_field($_POST['service']);
        $message = sanitize_textarea_field($_POST['message']);

        // Required field validation
        if (empty($name) || empty($email) || empty($service)) {
            $errors['required'] = 'All required fields must be filled out.';
        }

        // Email validation
        if (!empty($email) && !is_email($email)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if (!empty($errors)) {
            // Return or display errors on the form
            // Store errors in a session or pass back via a redirect
        } else {
            // Proceed with form processing, e.g., save to database or send email
        }
    }
}
add_action('init', 'handle_form_submission');
?>


<div class="page-wrapper" id="multistepForm">

<!-- HTML/PHP Template -->
<!-- Step 1: Personal Info -->
<div class="form-step active" data-step="1">
    <div class="form-content">
        <h3>Personal Details</h3>
        <!--------------------------------------------- Name  ------------------------------------------------>
        <div class="form-group">
            <input type="text" name="name" placeholder="Full Name" required>
        </div>
        <!--------------------------------------------- Range  ------------------------------------------------>
        <div class="form-group">
        <label>Age Range</label>
        <input type="range" name="age" min="18" max="100" value="25" 
               oninput="this.nextElementSibling.value = this.value">
        <output>25</output>
    </div>
        <!--------------------------------------------- Upload  ------------------------------------------------>
    <div class="form-group">
        <label>Profile Photo</label>
        <input type="file" name="photo" accept="image/*">
    </div>
        <!--------------------------------------------- Email  ------------------------------------------------>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email Address" required>
        </div>
    </div>
    <div class="button-controls">
        <div></div> 
        <button type="button" class="next-btn">Next</button>
    </div>
</div>

<!-- Step 2: Contact Details -->
<div class="form-step" data-step="2">
    <div class="form-content">
        <h3>Contact Details</h3>
        <div class="form-group">
            <input type="tel" name="phone" placeholder="Phone Number">
        </div>
        <div class="form-group">
            <input type="text" name="address" placeholder="Address">
        </div>
    </div>
    <div class="button-controls">
        <button type="button" class="prev-btn">Previous</button>
        <button type="button" class="next-btn">Next</button>
    </div>
</div>

<!-- Step 3: Service Selection -->
<div class="form-step" data-step="3">
    <div class="form-content">
        <h3>Select Service</h3>
        <div class="form-group">
            <select name="service" required>
                <option value="">Choose a Service</option>
                <option value="service1">Service 1</option>
                <option value="service2">Service 2</option>
                <option value="service3">Service 3</option>
            </select>
        </div>
    </div>
    <div class="button-controls">
        <button type="button" class="prev-btn">Previous</button>
        <button type="button" class="next-btn">Next</button>
    </div>
</div>

<!-- Step 4: Additional Information -->
<div class="form-step" data-step="4">
    <div class="form-content">
        <h3>Additional Information</h3>
        <div class="form-group">
            <textarea name="message" placeholder="Your Message" rows="4"></textarea>
        </div>
    </div>
    <div class="button-controls">
        <button type="button" class="prev-btn">Previous</button>
        <button type="button" class="next-btn">Next</button>
    </div>
</div>

<!-- Step 4: Additional Information -->
<div class="form-step" data-step="5">
    <div class="form-content">
        <h3>Additional Information</h3>
        <div class="form-group">
            <textarea name="message" placeholder="Your Message" rows="4"></textarea>
        </div>
    </div>
    <div class="button-controls">
        <button type="button" class="prev-btn">Previous</button>
        <button type="button" class="next-btn">Next</button>
    </div>
</div>

<!-- Step 5: Review & Submit -->
<div class="form-step" data-step="6">
    <div class="form-content">
        <h3>Review & Submit</h3>
        <div class="form-group">
            <div class="review-info"></div> <!-- Ensure this is correctly placed and visible -->
        </div>
    </div>
    <div class="button-controls">
        <button type="button" class="prev-btn">Previous</button>
        <button type="submit" name="form_submit" class="submit-btn">Submit</button>
    </div>
</div>

</div>
 
<style>
.multistep-form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
    
}

.progress-bar {
    display: flex;
    justify-content: space-between;
    margin: 0 20px 40px;
    position: relative;
}

.progress-bar::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    height: 3px;
    background: #e9ecef;
    z-index: 0;
}

.step {
    width: 40px;
    height: 40px;
    background: #fff;
    border: 3px solid #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: #6c757d;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
    
}

.step.active {
    border-color: #4361ee;
    color: #4361ee;
    transform: scale(1.1);
    box-shadow: 0 0 20px rgba(67, 97, 238, 0.3);
    
}

/* Form Content Styles */
.form-step {
    display: none;
    min-height: 400px;
    position: relative;
    padding-bottom: 70px;
  

    
}

.form-content {
    min-height: 300px;
    padding: 20px;
}
.form-step.active {
    display: block;
}

.form-group {
    margin-bottom: 25px;
    position: relative;
}


input, select, textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f8fafc;
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #4361ee;
    box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    background: #fff;
}
button {
    padding: 14px 28px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.next-btn, .submit-btn {
    background: #4361ee;
    color: white;
    border: none;
}

.prev-btn {
    background: #e2e8f0;
    color: #4a5568;
    border: none;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.next-btn:hover, .submit-btn:hover {
    background: #3651d4;
}

.prev-btn:hover {
    background: #cbd5e0;
}

.button-controls {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background: linear-gradient(to top, rgba(255,255,255,1), rgba(255,255,255,0.9));
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3), 0 1px 3px rgba(255, 255, 255, 0.1);
}
    .page-wrapper {
    max-width: 70vh;
    margin: 40px auto;
    padding: 40px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    box-shadow: inset 4px 4px 10px rgba(0, 0, 0, 0.2), inset -4px -4px 10px rgba(255, 255, 255, 0.8);
}
input.error, select.error, textarea.error {
    border-color: #ff0000;
}

input, select, textarea {
    /* existing styles */
    border: 2px solid #e2e8f0;
    /* add more styles if needed */
}
.error {
    border: 2px solid #ff0000;
}

.error-message {
    color: #ff0000;
    font-size: 14px;
    padding-top: 5px;
}

.review-info {
    padding: 15px;
    margin-top: 10px;
    background-color: white; /* Light grey background */
    border: 1px solid #e2e8f0; /* Light border */
    border-radius: 5px;
    min-height: 250px; /* Ensure it has space */
    color: black;
}

.review-info p {
    margin: 5px 0;
    font-size: 16px;
}

</style>
<script>
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

</script>