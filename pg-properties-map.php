<?php
/**
 * Template Name: Properties Map
 *
 * This template will display all properties on a Google Map
 * and list them below the map.
 */

get_header(); 

// Debug mode for site admins
$debug_mode = (current_user_can('manage_options') && isset($_GET['debug']));
$api_key = get_option('tetra_google_maps_api_key');
?>

<?php if ($debug_mode): ?>
<div class="properties-debug-panel" style="background: #f0f6fc; border-left: 4px solid #0066cc; padding: 15px 20px; margin-bottom: 20px;">
    <h3 style="margin-top: 0;">Properties Debug Information</h3>
    <p><strong>Google Maps API Key:</strong> <?php echo !empty($api_key) ? substr($api_key, 0, 6) . '...' . substr($api_key, -4) : 'Not set'; ?></p>
    <p><strong>Properties Data:</strong> 
    <?php
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        echo $query->post_count . ' properties found';
    ?>
    </p>
    <p><strong>Browser Info:</strong> <span id="browser-info">Checking...</span></p>
    <p><strong>Maps API Status:</strong> <span id="maps-api-status">Checking...</span></p>
    <p><strong>Scripts Loaded:</strong></p>
    <ul id="script-debug-list" style="font-family: monospace; font-size: 12px;"></ul>
    
    <script>
        // Display browser info
        document.getElementById('browser-info').textContent = navigator.userAgent;
        
        // Check for Maps API
        window.setTimeout(function() {
            var mapsStatus = document.getElementById('maps-api-status');
            if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                mapsStatus.textContent = 'Loaded successfully';
                mapsStatus.style.color = 'green';
            } else {
                mapsStatus.textContent = 'Failed to load';
                mapsStatus.style.color = 'red';
            }
        }, 3000);

        // List all loaded scripts
        var scriptList = document.getElementById('script-debug-list');
        var scripts = document.getElementsByTagName('script');
        for (var i = 0; i < scripts.length; i++) {
            var src = scripts[i].src || 'Inline script';
            var li = document.createElement('li');
            li.textContent = src;
            scriptList.appendChild(li);
        }
    </script>
</div>
<?php endif; ?>

<div class="c-properties-listing-container">
    <div class="container">
        <h1 class="c-properties-listing-title">Featured Properties</h1>
        
        <div class="c-properties-layout-container">
            <!-- Left Column - Properties List -->
            <div class="c-properties-list-column">
                <div class="c-properties-listing">
            <?php
            // The Query
            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $query = new WP_Query( $args );
            
            // The Loop
            if ( $query->have_posts() ) {
                echo '<div class="c-properties-grid">';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    
                    // Get ACF fields
                    $price = get_field('property_price');
                    $bedrooms = get_field('property_bedrooms');
                    $bathrooms = get_field('property_bathrooms');
                    $sqft = get_field('property_sqft');
                    $address = get_field('property_address');
                    
                    // Format the price
                    $formatted_price = '$' . number_format($price);
                      // Get property type taxonomy
                    $property_types = get_the_terms(get_the_ID(), 'project_type_tax');
                    $property_type_class = '';
                    $property_type_name = '';
                    
                    if ($property_types && !is_wp_error($property_types)) {
                        $property_type = $property_types[0]; // Get first term
                        $property_type_name = $property_type->name;
                        $property_type_class = sanitize_html_class(strtolower($property_type->slug));
                    }
                    
                    ?>
                    <div class="c-property-card" data-property-id="<?php echo get_the_ID(); ?>">
                        <?php if ($property_type_name) : ?>
                            <div class="c-property-taxonomy-ribbon <?php echo $property_type_class; ?>">
                                <?php echo $property_type_name; ?>
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php the_permalink(); ?>" class="c-property-card-link">
                            <div class="c-property-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/property-placeholder.jpg" alt="Property Image">
                                <?php endif; ?>
                            </div>
                            <div class="c-property-card-content">
                                <h3 class="c-property-card-title"><?php the_title(); ?></h3>
                                <p class="c-property-card-price"><?php echo $formatted_price; ?></p>
                                <p class="c-property-card-address"><?php echo $address; ?></p>
                                <div class="c-property-card-details">
                                    <?php if ($bedrooms) : ?>
                                        <span class="c-property-detail"><i class="fas fa-bed"></i> <?php echo $bedrooms; ?> bd</span>
                                    <?php endif; ?>
                                    
                                    <?php if ($bathrooms) : ?>
                                        <span class="c-property-detail"><i class="fas fa-bath"></i> <?php echo $bathrooms; ?> ba</span>
                                    <?php endif; ?>
                                    
                                    <?php if ($sqft) : ?>
                                        <span class="c-property-detail"><i class="fas fa-vector-square"></i> <?php echo number_format($sqft); ?> sqft</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php                }
                echo '</div>';
            } else {
                if ($debug_mode) {
                    echo '<div class="properties-warning" style="padding: 15px; background: #fcf8e3; border-left: 4px solid #f0ad4e; color: #8a6d3b;">';
                    echo '<p><strong>No Properties Found</strong></p>';
                    echo '<p>You need to <a href="' . admin_url('post-new.php?post_type=property') . '">add property listings</a> for them to appear on this page.</p>';
                    echo '</div>';
                } else {
                    echo '<p>No properties found.</p>';
                }
            }
            wp_reset_postdata();
            ?>
                </div>
            </div>
            
            <!-- Right Column - Map -->
            <div class="c-properties-map-column">
                <div class="c-properties-map-container">
                    <div id="propertiesMap" class="c-properties-map"></div>
                    
                    <?php if (empty($api_key)): ?>
                    <div class="properties-warning" style="margin-top: 15px; padding: 15px; background: #fcf8e3; border-left: 4px solid #f0ad4e; color: #8a6d3b;">
                        <p><strong>Google Maps API Key Missing</strong></p>
                        <p>Please add your Google Maps API key in the <a href="<?php echo admin_url('edit.php?post_type=property&page=property-settings'); ?>">Properties Settings</a> page.</p>
                    </div>
                    <?php else: ?>
                    <div id="map-loading-indicator" class="properties-info" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; background: rgba(255,255,255,0.8); padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <p><strong>Loading Google Maps...</strong></p>
                        <p style="font-size: 0.9em; margin-top: 5px;">If the map doesn't appear, please check that your API key allows access to this domain.</p>
                    </div>
                    <script>
                        // Remove loading indicator once map is initialized or after timeout
                        setTimeout(function() {
                            var loadingIndicator = document.getElementById('map-loading-indicator');
                            if (loadingIndicator) {
                                loadingIndicator.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($debug_mode && $query->have_posts()): ?>
<div class="properties-debug-panel" style="background: #f0f6fc; border-left: 4px solid #0066cc; padding: 15px 20px; margin: 20px 0;">
    <h3>Property Location Data</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align: left; padding: 5px; border-bottom: 1px solid #ccc;">ID</th>
                <th style="text-align: left; padding: 5px; border-bottom: 1px solid #ccc;">Title</th>
                <th style="text-align: left; padding: 5px; border-bottom: 1px solid #ccc;">Latitude</th>
                <th style="text-align: left; padding: 5px; border-bottom: 1px solid #ccc;">Longitude</th>
                <th style="text-align: left; padding: 5px; border-bottom: 1px solid #ccc;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query->rewind_posts();
            while ( $query->have_posts() ) {
                $query->the_post();
                $location = get_field('property_location');
                $has_valid_location = !empty($location) && !empty($location['lat']) && !empty($location['lng']);
                ?>
                <tr>
                    <td style="padding: 5px; border-bottom: 1px solid #eee;"><?php echo get_the_ID(); ?></td>
                    <td style="padding: 5px; border-bottom: 1px solid #eee;"><?php the_title(); ?></td>
                    <td style="padding: 5px; border-bottom: 1px solid #eee;"><?php echo $has_valid_location ? $location['lat'] : 'Not set'; ?></td>
                    <td style="padding: 5px; border-bottom: 1px solid #eee;"><?php echo $has_valid_location ? $location['lng'] : 'Not set'; ?></td>
                    <td style="padding: 5px; border-bottom: 1px solid #eee;">
                        <?php if ($has_valid_location): ?>
                            <span style="color: green;">✓ Valid</span>
                        <?php else: ?>
                            <span style="color: red;">✗ Invalid or missing</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
            wp_reset_postdata();
            ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
// Create a JavaScript object to store all property data for the map
var propertyMapData = [
    <?php
    // Reset the query to get the data again for the map
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            
            // Get location data
            $location = get_field('property_location');
            if ($location && !empty($location['lat']) && !empty($location['lng'])) {
                $price = get_field('property_price');
                $formatted_price = '$' . number_format($price);
                
                // Escape the title for JavaScript
                $title = esc_js(get_the_title());
                $address = esc_js(get_field('property_address'));
                $permalink = esc_js(get_permalink());
                
                // Get the thumbnail URL
                $thumbnail = '';
                if (has_post_thumbnail()) {
                    $thumbnail = esc_js(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'));
                } else {
                    $thumbnail = esc_js(get_template_directory_uri() . '/img/property-placeholder.jpg');
                }
                
                echo '{';
                echo "id: " . get_the_ID() . ",";
                echo "title: '" . $title . "',";
                echo "address: '" . $address . "',";
                echo "price: '" . $formatted_price . "',";
                echo "lat: " . $location['lat'] . ",";
                echo "lng: " . $location['lng'] . ",";
                echo "permalink: '" . $permalink . "',";
                echo "thumbnail: '" . $thumbnail . "'";
                echo '},';
            } elseif ($debug_mode) {
                // In debug mode, add a comment about the missing location
                echo "// Property ID " . get_the_ID() . " (" . esc_js(get_the_title()) . ") has invalid or missing location data\n";
            }
        }
    }
    wp_reset_postdata();
    ?>
];
</script>

<?php if ($debug_mode): ?>
<div style="margin: 20px 0; text-align: center;">
    <p><small>Debug mode is active. <a href="<?php echo remove_query_arg('debug'); ?>">Disable debug mode</a></small></p>
</div>
<?php endif; ?>

<?php get_footer(); ?>
