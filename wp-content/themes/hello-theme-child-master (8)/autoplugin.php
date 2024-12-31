<?php
/*
Plugin Name: AutoScout24 Integration
Description: Integrates AutoScout24 API with WordPress
*/

// Register API settings
add_action('admin_init', 'autoscout24_register_settings');
function autoscout24_register_settings() {
    register_setting('autoscout24_options', 'autoscout24_client_id');
    register_setting('autoscout24_options', 'autoscout24_client_secret');
}

// Add admin menu
add_action('admin_menu', 'autoscout24_admin_menu');
function autoscout24_admin_menu() {
    add_options_page('AutoScout24 Settings', 'AutoScout24', 'manage_options', 'autoscout24', 'autoscout24_settings_page');
}

// Settings page
function autoscout24_settings_page() {
    ?>
    <div class="wrap">
        <h2>AutoScout24 API Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('autoscout24_options'); ?>
            <table class="form-table">
                <tr>
                    <th>Client ID</th>
                    <td><input type="text" name="autoscout24_client_id" value="<?php echo esc_attr(get_option('autoscout24_client_id')); ?>" /></td>
                </tr>
                <tr>
                    <th>Client Secret</th>
                    <td><input type="password" name="autoscout24_client_secret" value="<?php echo esc_attr(get_option('autoscout24_client_secret')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Get API token
function autoscout24_get_token() {
    $client_id = get_option('autoscout24_client_id');
    $client_secret = get_option('autoscout24_client_secret');
    
    $response = wp_remote_post('https://auth.autoscout24.com/connect/token', array(
        'body' => array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret
        )
    ));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = json_decode(wp_remote_retrieve_body($response));
    return $body->access_token ?? false;
}

// Create vehicle listing
function autoscout24_create_listing($vehicle_data) {
    $token = autoscout24_get_token();
    if (!$token) {
        return false;
    }
    
    $response = wp_remote_post('https://listing-creation.api.autoscout24.com/listings', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($vehicle_data)
    ));
    
    return json_decode(wp_remote_retrieve_body($response));
}

// Shortcode to display vehicle
add_shortcode('autoscout24_vehicle', 'autoscout24_vehicle_shortcode');
function autoscout24_vehicle_shortcode($atts) {
    // Example vehicle data based on AutoScout24 docs
    $vehicle_data = array(
        "vehicle" => array(
            "category" => "Car",
            "make" => "BMW",
            "model" => "320",
            "firstRegistrationDate" => "2020-01",
            "mileage" => 50000,
            "fuel" => "Diesel",
            "price" => array(
                "amount" => 25000,
                "currency" => "EUR"
            )
        )
    );
    
    $html = '<div class="vehicle-listing">';
    $html .= '<h2>' . esc_html($vehicle_data['vehicle']['make'] . ' ' . $vehicle_data['vehicle']['model']) . '</h2>';
    $html .= '<ul>';
    $html .= '<li>Registration: ' . esc_html($vehicle_data['vehicle']['firstRegistrationDate']) . '</li>';
    $html .= '<li>Mileage: ' . number_format($vehicle_data['vehicle']['mileage']) . ' km</li>';
    $html .= '<li>Fuel: ' . esc_html($vehicle_data['vehicle']['fuel']) . '</li>';
    $html .= '<li>Price: €' . number_format($vehicle_data['vehicle']['price']['amount']) . '</li>';
    $html .= '</ul>';
    $html .= '</div>';
    
    return $html;
}