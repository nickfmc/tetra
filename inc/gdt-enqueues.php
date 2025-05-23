<?php
/*********************************************
SCRIPTS & ENQUEUING - #enque
**********************************************/

// loading modernizr, jquery, reply script and any custom scripts for this project
function gdt_scripts_and_styles() {

  if (!is_admin()) {

    // header scripts -----------
    $js_file_time = filemtime(get_stylesheet_directory() . '/dist/site_header.bundle.js');
    wp_register_script('gutendev-header-bundle', get_stylesheet_directory_uri() . '/dist/site_header.bundle.js', array('jquery'), $js_file_time, false);

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    // register main stylesheets
    $css_file_time = filemtime(get_stylesheet_directory() . '/dist/main.bundle.css');
    wp_register_style( 'gutendev-styles', get_stylesheet_directory_uri() . '/dist/main.bundle.css', array(), $css_file_time, 'all' );

    // all the scripts belong to the bundle (generated by webpack)
    $js_file_time = filemtime(get_stylesheet_directory() . '/dist/site.bundle.js');
    wp_register_script('gutendev-bundle', get_stylesheet_directory_uri() . '/dist/site.bundle.js', array('jquery'), $js_file_time, true);
  
     // Print Styles.
     $css_file_time = filemtime(get_stylesheet_directory() . '/dist/print.css');
     wp_register_style( 'gutendev-print', get_stylesheet_directory_uri() . '/dist/print.css', array(), $css_file_time, 'print' );

     
    // enqueue HEADER styles and scripts
    wp_enqueue_script( 'gutendev-header-bundle' );
    wp_enqueue_style( 'gutendev-styles' );
    wp_enqueue_style( 'gutendev-print' );
    
    // Font Awesome for property icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );

    // enqueue FOOTER styles and scripts
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'gutendev-bundle' );
    $translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
    wp_localize_script( 'gutendev-bundle', 'object_name', $translation_array );
  }
}

// Ensure we always have scripts.js functionality available
add_action('wp_enqueue_scripts', 'gdt_scripts_and_styles', 10);
