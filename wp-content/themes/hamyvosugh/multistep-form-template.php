<form id="multistepForm" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <?php wp_nonce_field('submit_multistep_form', 'multistep_form_nonce'); ?>

    <div class="page-wrapper">

        <!-- Step 1: Personal Info -->
        <div class="form-step active" data-step="1">
            <div class="form-content">
                <h3>Personal Details</h3>
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <label>Age Range</label>
                    <input type="range" name="age" min="18" max="100" value="25" oninput="this.nextElementSibling.value = this.value">
                    <output>25</output>
                </div>
                <div class="form-group">
                    <label>Profile Photo</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
            </div>
            <div class="button-controls">
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
                <button type="button" the="prev-btn">Previous</button>
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

        <!-- Step 5: Review & Submit -->
        <div class="form-step" data-step="5">
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
</form>