<?php
/**
 * Properties Dashboard Widget
 * 
 * Adds a helpful dashboard widget with information about setting up properties
 */

// Register the dashboard widget
function tetra_properties_dashboard_widget() {
    wp_add_dashboard_widget(
        'tetra_properties_dashboard_widget',
        'Featured Properties',
        'tetra_properties_dashboard_content'
    );
}
add_action('wp_dashboard_setup', 'tetra_properties_dashboard_widget');

// Dashboard widget content
function tetra_properties_dashboard_content() {    // Check if Google Maps API key is set
    $maps_api_key = get_option('tetra_google_maps_api_key');
    $api_status = !empty($maps_api_key) ? 
        '<span style="color: green;">✓ Set</span>' : 
        '<span style="color: red;">✗ Not Set</span> <a href="' . admin_url('edit.php?post_type=property&page=property-settings') . '">Add Key</a>';
    // Count properties
    $property_count = wp_count_posts('property');
    $published_properties = $property_count->publish;
    
    // Check if properties page template is used
    $properties_page = get_pages([
        'meta_key' => '_wp_page_template',
        'meta_value' => 'pg-properties-map.php'
    ]);
    $properties_page_status = !empty($properties_page) ? 
        '<span style="color: green;">✓ Created</span>' : 
        '<span style="color: orange;">? Not Found</span> <a href="' . admin_url('post-new.php?post_type=page') . '">Create Page</a>';
    
    ?>
    <div class="properties-dashboard-widget">
        <p>Manage your Featured Properties and their map display.</p>
        
        <div class="properties-dashboard-status">
            <h4>Quick Status</h4>
            <ul>
                <li><strong>Google Maps API Key:</strong> <?php echo $api_status; ?></li>
                <li><strong>Properties Page:</strong> <?php echo $properties_page_status; ?></li>
                <li><strong>Published Properties:</strong> <?php echo $published_properties; ?></li>
            </ul>
        </div>
          <div class="properties-dashboard-actions">
            <h4>Quick Actions</h4>
            <a href="<?php echo admin_url('post-new.php?post_type=property'); ?>" class="button">Add New Property</a>
            <a href="<?php echo admin_url('edit.php?post_type=property'); ?>" class="button">Manage Properties</a>
            <a href="<?php echo admin_url('edit.php?post_type=property&page=property-settings'); ?>" class="button">Settings</a>
        </div>
        
        <p style="margin-top: 15px; font-style: italic; font-size: 12px;">For detailed instructions, see the <a href="<?php echo get_template_directory_uri(); ?>/README-PROPERTIES.md" target="_blank">Properties Documentation</a>.</p>
    </div>
    <style>
        .properties-dashboard-status ul {
            margin-bottom: 20px;
        }
        .properties-dashboard-actions .button {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
    <?php
}
