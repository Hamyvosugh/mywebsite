<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );




/** google map **/ 

function google_maps_shortcode() {
    ob_start();
    ?>
    <div id="button-container" style="text-align: center; margin-bottom: 20px;">
        <button id="calculate-route" onclick="getUserLocation()" style="padding: 10px 20px; font-size: 16px;">Find Route</button>
    </div>

    <div id="distance-info-container">
        <div id="distance-info"></div>
    </div>

    <div id="map" style="height: 500px; width: 100%;"></div>

    <script type="text/javascript">
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                calculateRoute(userLat, userLng);
                getDistance(userLat, userLng);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function calculateRoute(userLat, userLng) {
        var myLocation = { lat: 50.40015398470949, lng: 8.05996511647672 };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: myLocation
        });

        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
        });

        directionsService.route({
            origin: { lat: userLat, lng: userLng },
            destination: myLocation,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                alert('Could not calculate route: ' + status);
            }
        });
    }

    function getDistance(userLat, userLng) {
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [{ lat: userLat, lng: userLng }],
            destinations: [{ lat: 50.40015398470949, lng: 8.05996511647672 }],
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                var distance = response.rows[0].elements[0].distance.text;
                var duration = response.rows[0].elements[0].duration.text;
                document.getElementById('distance-info').innerHTML =
                    '<div><strong>Entfernung von mir zu dir:</strong> ' + distance + '</div>' +
                    '<div><strong>Dauer von hier nach dort:</strong> ' + duration + '</div>';
            } else {
                alert('Error calculating distance: ' + status);
            }
        });
    }

    function loadGoogleMapsAPI() {
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }

    function initMap() {
        getUserLocation();
    }

    window.onload = loadGoogleMapsAPI;
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('google_map', 'google_maps_shortcode');



// افزودن شورت‌کد جدید برای ردیابی با استفاده از Directions API و Marker سفارشی
function product_tracking_map_shortcode() {
    ob_start();
    ?>
    <div id="remaining-time" style="font-size: 28px; color: white; margin-bottom: 10px;">Remaining Time: <span id="time"></span></div>
    <div id="product-tracking-map" style="height: 400px; width: 100%;"></div>
    
    <script>
      function initProductTrackingMap() {
        var startLocation = { lat: 48.14124280309121, lng: 11.589529914830363 }; // Marienplatz, Munich
        var endLocation = { lat: 48.1590202006631, lng: 11.516438023852835 };  // Sendlinger Str., Munich

        var map = new google.maps.Map(document.getElementById('product-tracking-map'), {
          zoom: 14, // زوم نزدیک‌تر به سطح خیابان
          center: startLocation
        });

        // استفاده از Directions API برای به دست آوردن مسیر رانندگی
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer({
          map: map,
          suppressMarkers: true // مخفی کردن نشانگرهای پیش‌فرض
        });

        directionsService.route(
          {
            origin: startLocation,
            destination: endLocation,
            travelMode: google.maps.TravelMode.DRIVING // حالت رانندگی
          },
          function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
              directionsRenderer.setDirections(response);

              var route = response.routes[0].overview_path;
              var marker = new google.maps.Marker({
                position: route[0], // نقطه شروع
                map: map,
                title: 'Ihr Produkt', // عنوان محصول
                label: { text: 'Ihr Produkt', color: 'black', fontSize: '26px' } // اضافه کردن نام محصول
              });

              var step = 0;
              var totalSteps = route.length;
              var moveSpeed = 100; // حرکت هر 900 میلی‌ثانیه
              var totalTime = (totalSteps * moveSpeed) / 1000; // زمان کل (ثانیه)
              document.getElementById('time').textContent = totalTime + ' seconds';

              var interval = setInterval(function() {
                if (step < totalSteps) {
                  step += 1;

                  var newPosition = route[step];
                  marker.setPosition(newPosition); // حرکت نشانگر
                  map.panTo(newPosition); // حرکت نقشه

                  // محاسبه زمان باقی‌مانده
                  var remainingTime = ((totalSteps - step) * moveSpeed) / 1000; // زمان باقی‌مانده (ثانیه)
                  document.getElementById('time').textContent = remainingTime.toFixed(1) + ' seconds';
                } else {
                  clearInterval(interval); // متوقف کردن حرکت پس از رسیدن
                  
                  // تغییر زمان باقی‌مانده به پیام "Ihr Produkt ist angekommen! "
                  document.getElementById('remaining-time').innerHTML = '<span style="color:green; font-size:20px;">Ihr Produkt ist angekommen!</span>';
                  
                  alert('Ihr Produkt ist angekommen! Bitte öffnen Sie die Tür.'); // پیام هشدار پس از رسیدن
                }
              }, moveSpeed); // حرکت نشانگر با سرعت مشخص
              
            } else {
              alert('Directions request failed due to ' + status);
            }
          }
        );
      }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initProductTrackingMap"></script>
    <?php
    return ob_get_clean();
}

add_shortcode('product_tracking_map', 'product_tracking_map_shortcode');


// GPT //

// GPT //

// Enqueue your scripts and localize the AJAX URL
function add_openai_chatbot_script() {
    // Pass the ajax URL to the inline script
    wp_localize_script('jquery', 'gptVars', array(
        'ajaxUrl' => admin_url('admin-ajax.php'), // Pass the AJAX URL to JavaScript
    ));
}
add_action('wp_enqueue_scripts', 'add_openai_chatbot_script');

// Handle the OpenAI API request via PHP and database interaction
function handle_openai_request() {
    // گرفتن API key از wp-config.php
    $api_key = OPENAI_API_KEY;

    // تصفیه ورودی کاربر از درخواست AJAX
    $user_input = sanitize_text_field($_POST['user_input']);

    // تشخیص زبان ورودی کاربر (برای مثال آلمانی)
    $detected_language = detect_language($user_input);  // تابعی برای تشخیص زبان کاربر

    // چک کردن اگر ورودی کاربر شناسه سفارش باشد (شروع با 'ORD-')
    if (strpos($user_input, 'ORD-') === 0) {
        // مدیریت منطق رهگیری سفارش با دیتابیس MySQL
        global $wpdb;

        // استفاده از پیشوند جدول وردپرس
        $table_name = $wpdb->prefix . 'orders'; 
        
        // اجرای کوئری برای پیدا کردن سفارش با order_id
        $order_info = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE order_id = %s", $user_input));

        if ($order_info) {
            // آماده کردن داده‌های سفارش برای ارسال به GPT
            $gpt_input = "Here is the order information:\nOrder ID: {$order_info->order_id}, Status: {$order_info->status}, Delivery Date: {$order_info->delivery_date}, Total Amount: {$order_info->total_amount}. Please respond in the same language as the user, which is {$detected_language}.";

            // ارسال اطلاعات به GPT برای جمله‌سازی به زبان کاربر
            $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json',
                ),
                'body' => json_encode(array(
                    'model' => 'gpt-3.5-turbo',
                    'messages' => array(
                        array('role' => 'system', 'content' => 'You are Hamy-AI, a helpful assistant.'),
                        array('role' => 'user', 'content' => $user_input), // ارسال ورودی کاربر به GPT
                        array('role' => 'system', 'content' => $gpt_input) // ارسال اطلاعات سفارش به GPT
                    ),
                    'max_tokens' => 150
                ))
            ));

            // مدیریت خطاهای احتمالی در پاسخ API
            if (is_wp_error($response)) {
                wp_send_json_error('API request failed');
            }

            // بازیابی بدنه پاسخ و ارسال آن به فرانت‌اند
            $body = wp_remote_retrieve_body($response);
            wp_send_json_success(json_decode($body));
        } else {
            // اگر سفارش پیدا نشود
            $response_message = "No order found for this Order ID.";
            if ($detected_language == 'de') {
                $response_message = "Keine Bestellung mit dieser Bestellnummer gefunden.";
            }
            wp_send_json_success(array('choices' => [['message' => ['content' => $response_message]]]));
        }
    } else {
        // اگر ورودی کاربر شناسه سفارش نبود، درخواست به OpenAI فرستاده شود
        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'model' => 'gpt-3.5-turbo',
                'messages' => array(
                    array('role' => 'system', 'content' => 'You are Hamy-AI, a helpful assistant.'),
                    array('role' => 'user', 'content' => $user_input)
                ),
                'max_tokens' => 100
            ))
        ));

        // مدیریت خطاهای احتمالی در پاسخ API
        if (is_wp_error($response)) {
            wp_send_json_error('API request failed');
        }

        // بازیابی بدنه پاسخ و ارسال آن به فرانت‌اند
        $body = wp_remote_retrieve_body($response);
        wp_send_json_success(json_decode($body));
    }
}

// تابعی برای تشخیص زبان کاربر
function detect_language($text) {
    // تشخیص زبان ساده (مثلاً اگر ورودی شامل کلمات خاص آلمانی باشد)
    if (preg_match('/\b(ich|meine|bestellung|wann|wird|geliefert)\b/i', $text)) {
        return 'de'; // آلمانی
    }
    // سایر زبان‌ها
    return 'en'; // پیش‌فرض: انگلیسی
}


add_action('wp_ajax_nopriv_handle_openai_request', 'handle_openai_request');
add_action('wp_ajax_handle_openai_request', 'handle_openai_request');

// enf GPT //
// enf GPT //







/* fetch data */
// تابع برای دریافت پست‌های اخیر از وبلاگ بلاگر
// تابع برای دریافت Blog ID با استفاده از کلمه کلیدی (که به URL تبدیل می‌شود)
function get_blog_id_by_keyword($keyword) {
    $api_key = BLOGGER_API_KEY;
    $blog_url = "https://" . urlencode($keyword) . ".blogspot.com"; // تبدیل کلمه کلیدی به URL وبلاگ
    $url = "https://www.googleapis.com/blogger/v3/blogs/byurl?url={$blog_url}&key={$api_key}";
    
    // ارسال درخواست به API برای دریافت Blog ID
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return false; // در صورت خطا، false برمی‌گرداند
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    // بررسی اینکه Blog ID وجود دارد یا نه
    return isset($data['id']) ? $data['id'] : false;
}

// تابع برای دریافت پست‌های وبلاگ بر اساس Blog ID
function get_recent_posts_by_keyword($keyword) {
    $blog_id = get_blog_id_by_keyword($keyword);
    
    if (!$blog_id) {
        return 'Blog not found for the given keyword.'; // اگر Blog ID پیدا نشد
    }

    $api_key = BLOGGER_API_KEY;
    $url = "https://www.googleapis.com/blogger/v3/blogs/{$blog_id}/posts?key={$api_key}&maxResults=5";
    
    // ارسال درخواست برای دریافت پست‌ها
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return 'Error retrieving posts.';
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!isset($data['items'])) {
        return 'No posts found.';
    }
    
    // ساختن HTML برای نمایش پست‌ها
    $output = '<h3>Recent Posts for ' . esc_html($keyword) . ':</h3><ul>';
    foreach ($data['items'] as $post) {
        $output .= '<li><a href="' . esc_url($post['url']) . '" target="_blank">' . esc_html($post['title']) . '</a></li>';
    }
    $output .= '</ul>';

    return $output;
}

// تابع برای نمایش فرم و نتیجه در صفحه
function display_keyword_to_url_form() {
    if (isset($_POST['keyword'])) {
        $keyword = sanitize_text_field($_POST['keyword']); // کلمه کلیدی وارد شده توسط کاربر
        echo get_recent_posts_by_keyword($keyword); // نمایش پست‌های مربوط به وبلاگ
    }

    // فرم HTML
    echo '
        <form method="POST">
            <label for="keyword">Enter a Keyword:</label>
            <input type="text" name="keyword" id="keyword" required>
            <button type="submit">Find Blog</button>
        </form>
    ';
}

// افزودن شورت‌کد برای نمایش فرم
add_shortcode('keyword_to_url_form', 'display_keyword_to_url_form');



/* fetch direct keywords */


function google_custom_search_shortcode() {
    ob_start(); ?>

 <div id="search-container">
    <input type="text" id="search-keyword" placeholder="Bitte geben Sie ein Schlüsselwort ein">
    <button id="search-button">Suchen</button>
    <div id="search-results"></div>
</div>

 <script>

   // Function to set a cookie
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000)); // Set expiration date
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Function to get a cookie by name
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Get search count from the cookie
let searchCount = parseInt(getCookie('searchCount')) || 0;

// Disable the button if the user has already reached the limit
if (searchCount >= 2) {
    document.getElementById('search-results').innerHTML = '<span class="search-limit-message">Das maximale Limit von 2 Suchvorgängen wurde erreicht.</span>';
    document.getElementById('search-button').disabled = true;
}

document.getElementById('search-button').addEventListener('click', function() {

    // Check if the user has exceeded the limit
    if (searchCount >= 2) {
        document.getElementById('search-results').innerHTML = '<span class="search-limit-message">Das maximale Limit von 2 Suchvorgängen wurde erreicht.</span>';
        return;
    }

    let keyword = document.getElementById('search-keyword').value;
    if (keyword.trim() === '') {
        alert('Please enter a keyword');
        return;
    }

    // Dynamically retrieve the API Key and Custom Search Engine ID from the server
    let apiKey = '<?php echo esc_js(GOOGLE_API_KEY); ?>';
    let cx = '<?php echo esc_js(GOOGLE_SEARCH_ENGINE_ID); ?>';

    // Restrict search to Instagram and limit results to 5
    let url = `https://www.googleapis.com/customsearch/v1?q=${keyword} amphibian site:instagram.com&key=${apiKey}&cx=${cx}&num=5`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let resultsDiv = document.getElementById('search-results');
            resultsDiv.innerHTML = ''; // Clear previous results
            if (data.items && data.items.length > 0) {
                // Limit the results to 5 items manually
                data.items.slice(0, 5).forEach(item => {
                    let resultItem = document.createElement('div');
                    resultItem.innerHTML = `<a href="${item.link}" target="_blank">${item.title}</a><br>`;
                    resultsDiv.appendChild(resultItem);
                });
            } else {
                resultsDiv.innerHTML = 'No results found.';
            }

            // Increment the search count and store it in the cookie
            searchCount++;
            setCookie('searchCount', searchCount, 7); // Cookie expires in 7 days

            // If the user reaches the limit, disable the button
            if (searchCount >= 2) {
                document.getElementById('search-results').innerHTML += '<br>You have reached the limit of 2 searches.';
                document.getElementById('search-button').disabled = true;
            }
        })
        .catch(error => {
            let resultsDiv = document.getElementById('search-results');
            resultsDiv.innerHTML = 'There was an error retrieving the data. Please try again later.';
            console.error('Error fetching data:', error);
        });
});
</script>





    <?php
    return ob_get_clean();
}
add_shortcode('google_custom_search', 'google_custom_search_shortcode');


/* registrer clock */

function enqueue_clock_scripts() {
    // Register and enqueue the clock.min.js file
    wp_enqueue_script(
        'clock-script',
        get_stylesheet_directory_uri() . '/Clock/js/clock.min.js',
        array(), // Dependencies can be added here
        null, // Version number, you can change it if needed
        true // Load in the footer
    );

    // Register and enqueue the timezones.min.js file
    wp_enqueue_script(
        'timezones-script',
        get_stylesheet_directory_uri() . '/Clock/js/timezones.min.js',
        array(), // Dependencies can be added here
        null, // Version number, you can change it if needed
        true // Load in the footer
    );

    // Register and enqueue the styles.css file
    wp_enqueue_style(
        'clock-styles',
        get_stylesheet_directory_uri() . '/Clock/css/styles.css',
        array(), // Dependencies can be added here
        null // Version number, you can change it if needed
    );
}

// Hook into wp_enqueue_scripts to load the scripts and styles
add_action('wp_enqueue_scripts', 'enqueue_clock_scripts');



// Translator Google //
// Handle Google Translation API request for blog content
function handle_google_translate_blog_request() {
    // Get the API key from wp-config.php
    $api_key = GOOGLE_API_KEY;

    // Sanitize the target language from the AJAX request
    $target_language = sanitize_text_field($_POST['target_language']);

    // Sample content to be translated (replace this later with dynamic content)
    $blog_content = "This is a sample blog post that will be translated to the selected language. You can replace this text with your actual blog content.";

    // Create the API request URL
    $url = 'https://translation.googleapis.com/language/translate/v2?key=' . $api_key;

    // Prepare the body for the request
    $body = json_encode(array(
        'q' => $blog_content,
        'target' => $target_language,
    ));

    // Make the API request
    $response = wp_remote_post($url, array(
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body' => $body,
    ));

    // Check if there is an error
    if (is_wp_error($response)) {
        wp_send_json_error('Translation request failed');
    }

    // Return the response to the front-end
    $body = wp_remote_retrieve_body($response);
    wp_send_json_success(json_decode($body));
}
add_action('wp_ajax_nopriv_google_translate_blog', 'handle_google_translate_blog_request');
add_action('wp_ajax_google_translate_blog', 'handle_google_translate_blog_request');


// control video buttons //
function enqueue_video_controls_script() {
    // Enqueue Font Awesome from CDN
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' );
    
    // Enqueue the custom JavaScript file (make sure the path is correct)
    wp_enqueue_script( 'custom-video-controls', get_stylesheet_directory_uri() . '/js/video-controls.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_video_controls_script' );


// mainrenance 


// Log user activity when they successfully log in via the bypass link
function log_user_activity_on_login($password_id, $password) {
    global $wpdb;
    
    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Get the user's location based on their IP address
    $location = get_location_from_ip($ip_address);

    // Get current time (login time)
    $login_time = current_time('mysql');  // WordPress current time in 'YYYY-MM-DD HH:MM:SS' format

    // Insert the login record into the user activity table
    $wpdb->insert(
        $wpdb->prefix . 'user_activity_log',
        array(
            'password_id'   => $password_id,  // Foreign key reference to wp_maintenance_passwords
            'password_used' => $password,     // The actual password used
            'ip_address'    => $ip_address,
            'location'      => $location,
            'login_time'    => $login_time,
        ),
        array('%d', '%s', '%s', '%s', '%s')  // Format: password_id (integer), password_used (string), ip_address (string), location (string), login_time (string)
    );

    return $wpdb->insert_id;
}

// Get the user's location based on their IP address
function get_location_from_ip($ip_address) {
    $response = wp_remote_get("http://ip-api.com/json/$ip_address");

    if (is_wp_error($response)) {
        return null;  // Return null if there's an error
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if ($data && $data->status == 'success') {
        return $data->city . ', ' . $data->country;  // Return city and country
    }

    return null;  // Return null if location cannot be found
}

// Custom menu in the admin dashboard
function add_user_activity_log_menu() {
    add_menu_page(
        'User Activity Log',            // Page title
        'Activity Log',                 // Menu title
        'manage_options',               // Capability
        'user-activity-log',            // Menu slug
        'display_user_activity_log',    // Callback function to display content
        'dashicons-list-view',          // Icon
        6                               // Position
    );
}
add_action('admin_menu', 'add_user_activity_log_menu');

// Display the content of the User Activity Log page
function display_user_activity_log() {
    global $wpdb;

    // Fetch data from the wp_user_activity_log table
    $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}user_activity_log ORDER BY login_time DESC");

    // Start building the page content
    echo '<div class="wrap">';
    echo '<h1>User Activity Log</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>
            <tr>
                <th>ID</th>
                <th>Password Used</th>
                <th>IP Address</th>
                <th>Location</th>
                <th>Login Time</th>
                <th>Logout Time</th>
                <th>Duration (seconds)</th>
            </tr>
          </thead>';
    echo '<tbody>';

    // Loop through the results and display them in a table
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->id) . '</td>';
        echo '<td>' . esc_html($row->password_used) . '</td>';
        echo '<td>' . esc_html($row->ip_address) . '</td>';
        echo '<td>' . esc_html($row->location) . '</td>';
        echo '<td>' . esc_html($row->login_time) . '</td>';
        echo '<td>' . esc_html($row->logout_time) . '</td>';
        echo '<td>' . esc_html($row->duration) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// human bot //
// // Enqueue the scripts and localize the AJAX URL
function add_chatbot_script() {
    wp_localize_script('jquery', 'gptVars', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'add_chatbot_script');

// Handle the chatbot AJAX request
function handle_bot_message() {
    // Sanitize the input
    $message = sanitize_text_field($_POST['message']);

    // Check for keywords (e.g., human assistance request)
    if (stripos($message, 'human') !== false || stripos($message, 'customer service') !== false) {
        $response = "I will connect you to a human agent now. Please wait.";
        // Here you would trigger the notification logic
    } else {
        // Default bot response
        $response = "You said: " . $message;
    }

    // Send response back to the AJAX call
    wp_send_json_success(array('response' => $response));
}
add_action('wp_ajax_nopriv_handle_bot_message', 'handle_bot_message');
add_action('wp_ajax_handle_bot_message', 'handle_bot_message');

// end human bot //








// voice bot open ai key //

// Debug-Logging aktivieren
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

// CORS Headers
add_action('init', function() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
});

// REST API Endpoint registrieren
add_action('rest_api_init', function () {
    register_rest_route('voice-chat/v1', '/process-audio', array(
        'methods' => 'POST',
        'callback' => 'process_audio_request',
        'permission_callback' => '__return_true'
    ));
});

function check_for_offer_request($text) {
    $offer_triggers = array(
        'zeig mir deine angebote',
        'zeige angebote',
        'welche angebote',
        'zeig mir die autos',
        'was gibt es für autos',
        'welche autos habt ihr',
        'angebote zeigen',
        'autos anzeigen'
    );

    $text = strtolower(trim($text));
    foreach ($offer_triggers as $trigger) {
        if (strpos($text, $trigger) !== false) {
            return true;
        }
    }
    return false;
}

function process_audio_request($request) {
    try {
        error_log('=== Starting process_audio_request ===');
        
        $openai_api_key = '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';
        
        $parameters = $request->get_json_params();
        error_log('Received parameters: ' . print_r($parameters, true));
        
        if (empty($parameters['audio'])) {
            error_log('No audio data received');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Keine Audio-Daten empfangen'
            ), 400);
        }

        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/temp';
        if (!file_exists($temp_dir)) {
            mkdir($temp_dir, 0755, true);
        }

        $temp_file = $temp_dir . '/audio_' . uniqid() . '.webm';
        $audio_data = base64_decode($parameters['audio']);
        
        if ($audio_data === false) {
            error_log('Failed to decode base64 audio');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Fehler beim Dekodieren der Audio-Daten'
            ), 400);
        }

        $write_result = file_put_contents($temp_file, $audio_data);
        error_log('Audio file written: ' . $temp_file . ' (Size: ' . strlen($audio_data) . ' bytes)');

        if ($write_result === false) {
            error_log('Failed to write audio file');
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Fehler beim Speichern der Audio-Datei'
            ), 500);
        }

        $whisper_response = send_to_whisper($temp_file, $openai_api_key);
        error_log('Whisper response: ' . print_r($whisper_response, true));

        unlink($temp_file);

        if (!$whisper_response) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Fehler bei der Spracherkennung'
            ), 500);
        }

        // Prüfen auf Angebotsnachfrage
        $show_offers = check_for_offer_request($whisper_response);
        error_log('Show offers: ' . ($show_offers ? 'true' : 'false'));

        // ChatGPT und TTS Anfrage
        $response = send_to_chatgpt($whisper_response, $openai_api_key, $show_offers);
        error_log('Final response: ' . print_r($response, true));

        return new WP_REST_Response(array(
            'success' => true,
            'response' => $response['text'],
            'audio' => $response['audio'],
            'showOffers' => $show_offers
        ), 200);

    } catch (Exception $e) {
        error_log('Exception in process_audio_request: ' . $e->getMessage());
        error_log('Stack trace: ' . $e->getTraceAsString());
        return new WP_REST_Response(array(
            'success' => false,
            'message' => $e->getMessage()
        ), 500);
    }
}

function send_to_whisper($audio_file, $api_key) {
    error_log('Sending to Whisper API: ' . $audio_file);
    
    if (!file_exists($audio_file)) {
        error_log('Audio file does not exist: ' . $audio_file);
        return false;
    }

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/audio/transcriptions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'file' => new CURLFILE($audio_file),
            'model' => 'whisper-1',
            'language' => 'de'
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $api_key
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        error_log('Curl error in send_to_whisper: ' . $err);
        return false;
    }
    
    $result = json_decode($response, true);
    return $result['text'] ?? false;
}

function send_to_chatgpt($text, $api_key, $show_offers = false) {
    error_log('Sending to ChatGPT: ' . $text . ' (show_offers: ' . ($show_offers ? 'true' : 'false') . ')');
    
    $curl = curl_init();
    
    // Angepasste System-Nachricht basierend auf Kontext
    $system_message = $show_offers 
        ? "Du bist ein Autoverkäufer-Assistent auf einer Auto-Marktplatz-Website. Deine Aufgabe ist es, dem Nutzer zu helfen, das passende Auto zu finden. Wenn jemand nach Angeboten fragt, antworte freundlich, dass du die aktuellen Angebote zeigen wirst. Sage zum Beispiel: 'Ich zeige Ihnen gerne unsere aktuellen Modelle. Hier sind unsere verfügbaren Fahrzeuge.'"
        : "Du bist ein Autoverkäufer-Assistent auf einer Auto-Marktplatz-Website. Beantworte Fragen zu Autos kompetent und freundlich.";

    $data = array(
        'model' => 'gpt-3.5-turbo',
        'messages' => array(
            array(
                'role' => 'system',
                'content' => $system_message
            ),
            array(
                'role' => 'user',
                'content' => $text
            )
        ),
        'temperature' => 0.7,
        'max_tokens' => 150
    );
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        error_log('Curl error in send_to_chatgpt: ' . $err);
        return array(
            'text' => 'Entschuldigung, es gab einen Fehler bei der Verarbeitung.',
            'audio' => null
        );
    }
    
    $result = json_decode($response, true);
    $text_response = $result['choices'][0]['message']['content'] ?? 'Entschuldigung, ich konnte keine passende Antwort generieren.';
    
    // Text-to-Speech API aufrufen
    $audio_response = send_to_tts($text_response, $api_key);
    
    return array(
        'text' => $text_response,
        'audio' => $audio_response
    );
}

function send_to_tts($text, $api_key) {
    error_log('Sending to TTS API: ' . $text);
    
    $curl = curl_init();
    
    $data = array(
        'model' => 'tts-1',
        'input' => $text,
        'voice' => 'nova',  // Verfügbare Stimmen: alloy, echo, fable, onyx, nova, shimmer
        'response_format' => 'mp3',
        'speed' => 1.0
    );
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/audio/speech',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        error_log('TTS Curl error: ' . $err);
        return null;
    }
    
    return base64_encode($response);
}


// voice calendar //
// 


// Register REST API endpoint
add_action('rest_api_init', function () {
    register_rest_route('avatar-tts/v1', '/speak', array(
        'methods' => 'POST',
        'callback' => 'process_tts_request',
        'permission_callback' => '__return_true'
    ));
});

function process_tts_request($request) {
    // Get the text from the request
    $text = $request->get_param('text');
    
    // OpenAI API configuration
    $api_key = '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'; // Replace with your API key
    $api_url = 'https://api.openai.com/v1/audio/speech';
    
    // Prepare the request
    $args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode(array(
            'model' => 'tts-1',
            'input' => $text,
            'voice' => 'nova', // Using nova voice which works well with Persian
            'response_format' => 'mp3',
            'speed' => 1.0
        )),
        'timeout' => 30
    );
    
    // Make the request to OpenAI
    $response = wp_remote_post($api_url, $args);
    
    if (is_wp_error($response)) {
        return new WP_Error('tts_error', $response->get_error_message());
    }
    
    // Get the audio content
    $audio_content = wp_remote_retrieve_body($response);
    
    if (empty($audio_content)) {
        return new WP_Error('tts_error', 'Empty response from OpenAI');
    }
    
    // Generate unique filename
    $filename = 'tts-' . uniqid() . '.mp3';
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['path'] . '/' . $filename;
    $file_url = $upload_dir['url'] . '/' . $filename;
    
    // Save the audio file
    file_put_contents($file_path, $audio_content);
    
    // Return the URL of the saved audio file
    return array(
        'success' => true,
        'audio_url' => $file_url
    );
}

// Add cleanup for old audio files
add_action('wp_scheduled_delete', 'cleanup_tts_files');

function cleanup_tts_files() {
    $upload_dir = wp_upload_dir();
    $files = glob($upload_dir['path'] . '/tts-*.mp3');
    
    foreach ($files as $file) {
        // Delete files older than 1 hour
        if (time() - filemtime($file) > 3600) {
            unlink($file);
        }
    }
}




// Text Bericht für Auto3 //

// AJAX handler for text-to-speech conversion
function car_presentation_text_to_speech() {
    $text = sanitize_text_field($_POST['text']);
    if (empty($text)) {
        wp_send_json_error('Kein Text angegeben');
        return;
    }

    // Your OpenAI API key directly here for testing
    $api_key = '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';

    $response = wp_remote_post('https://api.openai.com/v1/audio/speech', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode(array(
            'model' => 'tts-1',
            'input' => $text,
            'voice' => 'onyx',  // Using Onyx for German voice
            'response_format' => 'mp3'
        )),
        'timeout' => 30
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('API-Verbindungsfehler: ' . $response->get_error_message());
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $http_code = wp_remote_retrieve_response_code($response);

    if ($http_code !== 200) {
        wp_send_json_error('OpenAI API Error: ' . $body);
        return;
    }

    // Create uploads directory if it doesn't exist
    $upload_dir = wp_upload_dir();
    $audio_dir = $upload_dir['basedir'] . '/car-presentations';
    if (!file_exists($audio_dir)) {
        wp_mkdir_p($audio_dir);
    }

    // Save the audio file
    $filename = 'presentation-' . uniqid() . '.mp3';
    $file_path = $audio_dir . '/' . $filename;
    file_put_contents($file_path, $body);

    // Return the URL to the audio file
    wp_send_json_success(array(
        'audio_url' => $upload_dir['baseurl'] . '/car-presentations/' . $filename
    ));
}
add_action('wp_ajax_car_presentation_text_to_speech', 'car_presentation_text_to_speech');
add_action('wp_ajax_nopriv_car_presentation_text_to_speech', 'car_presentation_text_to_speech');

// AJAX handler for booking appointments
function handle_test_drive_booking() {
    $date = sanitize_text_field($_POST['date']);
    $time = sanitize_text_field($_POST['time']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);

    // Here you would typically save to database
    // For testing, we'll just return success
    wp_send_json_success(array(
        'message' => 'Buchung erfolgreich',
        'appointment' => array(
            'date' => $date,
            'time' => $time,
            'name' => $name
        )
    ));
}
add_action('wp_ajax_test_drive_booking', 'handle_test_drive_booking');
add_action('wp_ajax_nopriv_test_drive_booking', 'handle_test_drive_booking');

// Clean up old audio files (runs with WordPress cleanup)
function clean_old_audio_files() {
    $upload_dir = wp_upload_dir();
    $audio_dir = $upload_dir['basedir'] . '/car-presentations';
    
    if (file_exists($audio_dir)) {
        $files = glob($audio_dir . '/*');
        $now = time();
        
        foreach ($files as $file) {
            if ($now - filemtime($file) > 24 * 3600) { // Delete files older than 24 hours
                unlink($file);
            }
        }
    }
}
add_action('wp_scheduled_delete', 'clean_old_audio_files');

// Add available time slots (you can modify these as needed)
function get_available_time_slots() {
    $slots = array(
        date('Y-m-d', strtotime('+1 day')) => array('09:00', '11:30', '14:00', '16:30'),
        date('Y-m-d', strtotime('+2 day')) => array('10:00', '13:00', '15:00'),
        date('Y-m-d', strtotime('+3 day')) => array('09:30', '12:00', '14:30'),
        date('Y-m-d', strtotime('+4 day')) => array('11:00', '13:30', '16:00'),
        date('Y-m-d', strtotime('+5 day')) => array('10:30', '12:30', '15:30')
    );

    return $slots;
}

// AJAX handler for getting available time slots
function get_available_slots() {
    wp_send_json_success(get_available_time_slots());
}
add_action('wp_ajax_get_available_slots', 'get_available_slots');
add_action('wp_ajax_nopriv_get_available_slots', 'get_available_slots');

// Optional: Add email notification for bookings
function send_booking_confirmation($booking_data) {
    $to = $booking_data['email'];
    $subject = 'Ihre Probefahrt-Bestätigung';
    $message = sprintf(
        "Sehr geehrte(r) %s,\n\nIhre Probefahrt wurde erfolgreich gebucht für:\nDatum: %s\nUhrzeit: %s\n\nWir freuen uns darauf, Sie in unserem Autohaus begrüßen zu dürfen!\n\nMit freundlichen Grüßen\nIhr Autohaus-Team",
        $booking_data['name'],
        $booking_data['date'],
        $booking_data['time']
    );
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    return wp_mail($to, $subject, $message, $headers);
}

// Register scripts and styles (optional, if you need additional resources)
function register_car_presentation_assets() {
    wp_register_style(
        'car-presentation-styles',
        get_template_directory_uri() . '/assets/css/car-presentation.css',
        array(),
        '1.0.0'
    );

    wp_register_script(
        'car-presentation-script',
        get_template_directory_uri() . '/assets/js/car-presentation.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_localize_script('car-presentation-script', 'carPresentation', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('car_presentation_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'register_car_presentation_assets');