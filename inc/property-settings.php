<?php
/**
 * Add a theme settings page for properties
 */

// Add settings page as a submenu under 'Featured Properties'
function tetra_add_property_settings_page() {
    add_submenu_page(
        'edit.php?post_type=property',  // Parent slug (Featured Properties)
        'Properties Settings',          // Page title
        'Settings',                     // Menu title
        'manage_options',               // Capability
        'property-settings',            // Menu slug
        'tetra_properties_settings_page' // Callback function
    );
}
add_action('admin_menu', 'tetra_add_property_settings_page');

// Register settings
function tetra_register_properties_settings() {
    register_setting('tetra_properties_settings', 'tetra_google_maps_api_key');
}
add_action('admin_init', 'tetra_register_properties_settings');

// Theme settings page display
function tetra_properties_settings_page() {
    // Check if API key was just saved
    $updated = false;
    if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') {
        $updated = true;
    }
    
    // Get current API key
    $api_key = get_option('tetra_google_maps_api_key');
    
    ?>
    <div class="wrap">
        <h1>Properties Settings</h1>
        
        <?php if ($updated && !empty($api_key)) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Settings saved successfully!</strong></p>
            </div>
        <?php endif; ?>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('tetra_properties_settings');
            do_settings_sections('tetra_properties_settings');
            ?>
            <table class="form-table">
                <tr valign="top">                    <th scope="row">Google Maps API Key</th>
                    <td>
                        <input type="text" name="tetra_google_maps_api_key" value="<?php echo esc_attr($api_key); ?>" style="width: 350px;" />
                        <p class="description">Enter your Google Maps API key. <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">How to get an API key</a></p>
                        <p class="description" style="color: #d63638;"><strong>Important:</strong> Make sure to enable the following APIs in your Google Cloud Console:</p>
                        <ul style="list-style: disc; margin-left: 20px; color: #d63638;">
                            <li>Maps JavaScript API</li>
                            <li>Geocoding API</li>
                            <li>Places API (recommended)</li>
                        </ul>
                        
                        <?php if (!empty($api_key)) : ?>
                            <div style="margin-top: 15px;">
                                <button type="button" class="button" id="test-google-maps-api">Test API Key</button>
                                <div id="api-test-result" style="margin-top: 10px; padding: 10px; display: none;"></div>
                            </div>
                              <script>
                                jQuery(document).ready(function($) {
                                    $('#test-google-maps-api').on('click', function() {
                                        const apiKey = '<?php echo esc_js($api_key); ?>';
                                        const resultDiv = $('#api-test-result');
                                        
                                        resultDiv.html('<p>Testing API key... <span class="spinner is-active" style="float: none;"></span></p>');
                                        resultDiv.css({
                                            'display': 'block',
                                            'background': '#f8f9fa',
                                            'border-left': '4px solid #646970'
                                        });
                                        
                                        // Create a test script element
                                        const script = document.createElement('script');
                                        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&callback=testGoogleMapsAPIValidation&v=${Math.random()}`;
                                        script.async = true;
                                        script.defer = true;
                                        
                                        // Define success callback with actual validation
                                        window.testGoogleMapsAPIValidation = function() {
                                            try {
                                                // Try to create a map - this will fail if the API key is invalid
                                                const mapTest = new google.maps.Map(document.createElement('div'));
                                                const geocoder = new google.maps.Geocoder();
                                                
                                                // Try to geocode a simple address to test API key permissions
                                                geocoder.geocode({ address: 'New York, NY' }, function(results, status) {
                                                    if (status === google.maps.GeocoderStatus.OK) {
                                                        resultDiv.html('<p style="color: #00a32a;"><strong>✓ Success!</strong> Google Maps API key is working correctly and has proper permissions.</p>');
                                                        resultDiv.css('background', '#f0f6fc');
                                                        resultDiv.css('border-left', '4px solid #00a32a');
                                                    } else {
                                                        resultDiv.html(`<p style="color: #d63638;"><strong>✗ API Error</strong><br>Your API key might be missing required API access. Error: ${status}<br>Make sure the Geocoding API is enabled.</p>`);
                                                        resultDiv.css('background', '#fcf0f1');
                                                        resultDiv.css('border-left', '4px solid #d63638');
                                                    }
                                                });
                                            } catch (error) {
                                                resultDiv.html(`<p style="color: #d63638;"><strong>✗ JavaScript Error</strong><br>${error.message}</p>`);
                                                resultDiv.css('background', '#fcf0f1');
                                                resultDiv.css('border-left', '4px solid #d63638');
                                            }
                                        };
                                        
                                        // Define error callback
                                        window.gm_authFailure = function() {
                                            resultDiv.html('<p style="color: #d63638;"><strong>✗ Authentication Error</strong><br>Your API key might be invalid or restricted. Check:<br>- API key is correct<br>- Maps JavaScript API is enabled<br>- No referrer restrictions or add your domain to allowed referrers</p>');
                                            resultDiv.css('background', '#fcf0f1');
                                            resultDiv.css('border-left', '4px solid #d63638');
                                        };
                                        
                                        // Handle network or other errors
                                        script.onerror = function() {
                                            resultDiv.html('<p style="color: #d63638;"><strong>✗ Network Error</strong><br>Could not load Google Maps API. Check your internet connection or if your site is password protected.</p>');
                                            resultDiv.css('background', '#fcf0f1');
                                            resultDiv.css('border-left', '4px solid #d63638');
                                        };
                                        
                                        // Add the script to the page
                                        document.body.appendChild(script);
                                        
                                        // Set timeout in case neither success nor error callbacks are fired
                                        setTimeout(function() {
                                            if (resultDiv.find('.spinner').length > 0) {
                                                resultDiv.html('<p style="color: #d63638;"><strong>✗ Timeout Error</strong><br>Google Maps API did not respond. Check if your site has content security policies or is password protected.</p>');
                                                resultDiv.css('background', '#fcf0f1');
                                                resultDiv.css('border-left', '4px solid #d63638');
                                            }
                                        }, 5000);
                                    });
                                });
                            </script>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
          <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2>Troubleshooting Password-Protected Sites</h2>
            <p>If your site is password-protected (using .htaccess or similar), Google Maps might not work properly because:</p>
            <ol>
                <li>API requests to Google might be blocked by the authentication</li>
                <li>Google can't properly validate the referrer URL due to the authentication layer</li>
            </ol>
            <p><strong>Solutions:</strong></p>
            <ol>
                <li>Add your local development domain to the list of allowed referrers in Google Cloud Console</li>
                <li>Ensure HTTP referrers are allowed in your API key restrictions</li>
                <li>For development, consider creating a separate API key with no restrictions</li>
            </ol>
            <p><a href="<?php echo get_template_directory_uri(); ?>/GOOGLE-MAPS-TROUBLESHOOTING.md" target="_blank">View Complete Troubleshooting Guide</a></p>
        </div>
    </div>
    <?php
}

// Function to get Google Maps API key
function tetra_get_google_maps_api_key() {
    return get_option('tetra_google_maps_api_key');
}

// Enqueue Google Maps API with the saved key
function tetra_enqueue_google_maps() {
    // Only enqueue on properties page template or single property
    if (is_page_template('pg-properties-map.php') || is_singular('property')) {
        $api_key = tetra_get_google_maps_api_key();
        
        if (!empty($api_key)) {
            // Add version parameter to prevent caching issues
            $version = wp_rand(10000, 99999);
            
            // Enqueue Google Maps API
            wp_enqueue_script(
                'google-maps',
                'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&v=' . $version,
                array('jquery'),
                null,
                true  // Load in footer
            );
            
            // Error handling for auth failures
            wp_add_inline_script('google-maps', '
                function gm_authFailure() {
                    console.error("Google Maps authentication error");
                    var mapElements = document.querySelectorAll(".c-properties-map, .c-single-property-map-container");
                    mapElements.forEach(function(element) {
                        element.innerHTML = "<div style=\'padding: 20px; background: #f8d7da; color: #721c24; text-align: center;\'>" +
                            "<p><strong>Google Maps API Error</strong></p>" +
                            "<p>There was a problem with the Google Maps API key. Please contact the administrator.</p></div>";
                    });
                }
            ', 'before');
        } else {
            // Display admin notice if API key is missing
            if (current_user_can('manage_options')) {
                add_action('admin_notices', 'tetra_google_maps_api_notice');
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'tetra_enqueue_google_maps', 99);

// Admin notice for missing Google Maps API key
function tetra_google_maps_api_notice() {
    ?>
    <div class="notice notice-error">
        <p>
            <strong>Google Maps API Key Missing:</strong> You need to <a href="<?php echo admin_url('edit.php?post_type=property&page=property-settings'); ?>">add your Google Maps API key</a> for the property map to work.
        </p>
    </div>
    <?php
}
