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

?>
