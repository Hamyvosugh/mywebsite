jQuery(document).ready(function($) {
    $('#maintenance-password-form').on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting normally

        var password = $('#password-input').val(); // Get the entered password

        $.ajax({
            url: maintenance_ajax_object.ajax_url, // Use the localized Ajax URL
            method: 'POST',
            data: {
                action: 'verify_maintenance_password',
                password: password
            },
            success: function(response) {
                if (response.success) {
                    $('#error-message').html('<p style="color: green;">' + response.data + '</p>');
                    setTimeout(function() {
                        window.location.href = maintenance_ajax_object.redirect_url; // Redirect if successful
                    }, 2000); // Optional delay for feedback
                } else {
                    $('#error-message').html('<p>' + response.data + '</p>');
                }
            },
            error: function() {
                $('#error-message').html('<p>There was an error. Please try again.</p>');
            }
        });
    });
});