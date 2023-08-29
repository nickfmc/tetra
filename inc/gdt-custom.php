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

?>
