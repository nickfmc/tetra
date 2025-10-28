<?php
/**
 * GutenDev Custom Post Type Registration Party
 * REMBEMBER -> Uncomment / add this file to functions.php
 */

// register ###REPLACE_ME### custom post type
add_action( 'init', 'gdt_Staff_reg' );

// create a custom post type and name it
function gdt_Staff_reg() {
  $singular = 'Staff Member';
  $plural = 'Staff Members';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => true,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 21,
    'menu_icon'            => 'dashicons-book',
    'rewrite'              =>  array( 'slug' => 'about_us', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => false, // true or use custom slug: 'custom_type_url/past' */
    'hierarchical'         => false,
    'supports'             => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' )
  );
  register_post_type( 'staff_type', $args );
}

// register Featured Properties custom post type
add_action( 'init', 'gdt_Properties_reg' );

// create the Featured Properties custom post type
function gdt_Properties_reg() {
  $singular = 'Featured Property';
  $plural = 'Featured Properties';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => false,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 22,
    'menu_icon'            => 'dashicons-location-alt',
    'rewrite'              =>  array( 'slug' => 'properties', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => true,
    'hierarchical'         => false,
    'supports'             => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' )
  );
  register_post_type( 'property', $args );
}

// register Tetra-Bute custom post type
add_action( 'init', 'gdt_TetraBute_reg' );

// create the Tetra-Bute custom post type
function gdt_TetraBute_reg() {
  $singular = 'Tetra-Bute';
  $plural = 'Tetra-Butes';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => false,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 23,
    'menu_icon'            => 'dashicons-heart',
    'rewrite'              =>  array( 'slug' => 'tetra-butes', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => true,
    'hierarchical'         => false,
    'supports'             => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' )
  );
  register_post_type( 'tetra_bute', $args );
}

// register Hot Property custom post type
add_action( 'init', 'gdt_HotProperty_reg' );

// create the Hot Property custom post type for landing pages
function gdt_HotProperty_reg() {
  $singular = 'Hot Property';
  $plural = 'Hot Properties';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => false,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 26,
    'menu_icon'            => 'dashicons-star-filled',
    'rewrite'              =>  array( 'slug' => 'hot-property', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => false,
    'hierarchical'         => false,
    'supports'             => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes', 'revisions' )
  );
  register_post_type( 'hot_property', $args );
}

// Add custom columns to hot property admin list
function hot_property_admin_columns($columns) {
    $columns['hp_status'] = __('Status');
    $columns['hp_price'] = __('Price');
    $columns['hp_leads'] = __('Leads');
    $columns['hp_views'] = __('Views');
    return $columns;
}
add_filter('manage_hot_property_posts_columns', 'hot_property_admin_columns');

// Populate custom columns
function hot_property_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'hp_status':
            $status = get_field('property_status', $post_id);
            $status_class = '';
            switch ($status) {
                case 'available':
                    $status_class = 'status-available';
                    break;
                case 'under_offer':
                    $status_class = 'status-under-offer';
                    break;
                case 'sold':
                    $status_class = 'status-sold';
                    break;
            }
            echo '<span class="' . $status_class . '">' . ucwords(str_replace('_', ' ', $status)) . '</span>';
            break;
        
        case 'hp_price':
            $price = get_field('property_price', $post_id);
            echo $price ? '$' . number_format($price) : 'POA';
            break;
            
        case 'hp_leads':
            $leads = get_post_meta($post_id, '_hot_property_leads', true);
            echo intval($leads);
            break;
            
        case 'hp_views':
            $views = get_post_meta($post_id, '_hot_property_views', true);
            echo intval($views);
            break;
    }
}
add_action('manage_hot_property_posts_custom_column', 'hot_property_admin_column_content', 10, 2);

// Add admin CSS for status indicators
function hot_property_admin_css() {
    echo '<style>
        .status-available { color: #46b450; font-weight: bold; }
        .status-under-offer { color: #ffb900; font-weight: bold; }
        .status-sold { color: #dc3232; font-weight: bold; }
    </style>';
}
add_action('admin_head', 'hot_property_admin_css');

// Track page views
function track_hot_property_view() {
    if (is_singular('hot_property')) {
        $post_id = get_the_ID();
        $views = get_post_meta($post_id, '_hot_property_views', true);
        $views = $views ? intval($views) + 1 : 1;
        update_post_meta($post_id, '_hot_property_views', $views);
    }
}
add_action('wp_head', 'track_hot_property_view');

// Add custom meta box for quick stats
function hot_property_stats_meta_box() {
    add_meta_box(
        'hot_property_stats',
        __('Landing Page Stats'),
        'hot_property_stats_callback',
        'hot_property',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'hot_property_stats_meta_box');

function hot_property_stats_callback($post) {
    $views = get_post_meta($post->ID, '_hot_property_views', true);
    $leads = get_post_meta($post->ID, '_hot_property_leads', true);
    $conversion_rate = ($views > 0 && $leads > 0) ? round(($leads / $views) * 100, 2) : 0;
    
    echo '<p><strong>Page Views:</strong> ' . intval($views) . '</p>';
    echo '<p><strong>Leads Generated:</strong> ' . intval($leads) . '</p>';
    echo '<p><strong>Conversion Rate:</strong> ' . $conversion_rate . '%</p>';
    echo '<p><em>Stats update automatically when visitors view the page and submit forms.</em></p>';
    
    $permalink = get_permalink($post->ID);
    if ($permalink) {
        echo '<p><strong>Landing Page URL:</strong><br>';
        echo '<input type="text" value="' . esc_url($permalink) . '" readonly style="width: 100%; font-size: 11px;" onclick="this.select();">';
        echo '</p>';
    }
}

?>
