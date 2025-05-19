<?php
/**
 * Custom functions for this project? If yes, drop them here!
 */

 add_action( 'wp', function() {
  add_filter( 'generateblocks_media_query', function( $query ) {
      $query['desktop'] = '(min-width: 1101px)';
      $query['tablet'] = '(max-width: 1100px)';
      $query['tablet_only'] = '(max-width: 1100px)';
      // $query['tablet_only'] = '(max-width: 968px) and (min-width: 1101px)';
      $query['mobile'] = '(max-width: 968px)';

      return $query;
  } );
}, 20 );

  // If using acf icon picker - https://github.com/houke/acf-icon-picker -  modify the path to the icons directory
//   add_filter( 'acf_icon_path_suffix', 'acf_icon_path_suffix' );

//   function acf_icon_path_suffix( $path_suffix ) {
//       return 'img/icons/';
//   }
  
//used for Stackable blocks support - match to wrapper width 
global $content_width;
$content_width = 920;


function current_year_shortcode() {
  $current_year = date('Y');
  return $current_year;
}
add_shortcode('current_year', 'current_year_shortcode');

/**
 * Pass the Google Maps API key to ACF
 */
function tetra_acf_google_map_api($api) {
    $api_key = get_option('tetra_google_maps_api_key');
    
    if (!empty($api_key)) {
        $api['key'] = $api_key;
    }
    
    return $api;
}
add_filter('acf/fields/google_map/api', 'tetra_acf_google_map_api');

/**
 * Alternative method to set the Google Maps API key for ACF
 */
function tetra_acf_init() {
    $api_key = get_option('tetra_google_maps_api_key');
    
    if (!empty($api_key)) {
        acf_update_setting('google_api_key', $api_key);
    }
}
add_action('acf/init', 'tetra_acf_init');

?>
