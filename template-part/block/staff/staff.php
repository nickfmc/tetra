<?php

/**
 * blockname Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'c-staffblock-' . $block['id'];
if( !empty($block['anchor']) ) { 
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-staffblock';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
  <?php
  $args = array(
    'post_type' => 'staff_type',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
  );
  $query = new WP_Query( $args );
  if ( $query->have_posts() ) {
    echo '<h3 class="u-light-blue mb-2">Our Team</h3>';
    echo '<p>Meet the team that makes it all happen.</p>';
    echo '<div style="display:none;" class="c-modal-holder">';
    while ( $query->have_posts() ) {
      $query->the_post();
      global $post;
      echo '<div id="pop-' . $post->post_name . '" class="c-modal-holder-item mfp-hide white-popup-block" data-member="' . $post->post_name . '">';
      echo '<a class="popup-modal-dismiss" href="#">Close <span>X</span></a>';
      the_content();
      echo '</div>';
    }
    echo '</div>';
    echo '<div class="c-staff-member-grid">';
    while ( $query->have_posts() ) {
      $query->the_post();
      global $post;
      echo '<div class="c-staff-member" data-member="' . $post->post_name . '">';
      echo '<a class="popup-modal u-cover-link" href="#pop-' . $post->post_name . '"></a>';
      echo '<div class="c-staff-img">';
      echo '<div class="c-staff-img-overlay"><span>View Bio</span></div>'; 
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'full');
      } else {
        echo '<img src="' . bloginfo( 'template_url' ) . '/img/placeholder.png" alt="placeholder img" />';
      }
      echo '</div>';
      
      echo '<div class="c-staff-name">';
      echo '<h5>' . get_the_title() . '</h5>';
      echo '</div>';
      if ( get_field( 'position', get_the_ID() ) ) {
        echo '<div class="c-staff-title">' . get_field( 'position', get_the_ID() ) . '</div>';
      }
     
      // echo '<span class="c-staff-member-trigger c-btn-text">';
      // echo '<a class="popup-modal" href="#pop-' . $post->post_name . '">View Bio <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><path fill="currentColor" d="m183.505 496l-97.268-97.27l143.175-143.174L86.237 112.38l97.268-97.27l143.227 143.228l11.316 11.209l85.9 85.9l.051.05l-11.311 11.419l-85.9 85.9l-.055-.054Zm-52.013-97.27l52.013 52.014L326.629 307.62l.055.054l52.116-52.118l-52.127-52.128l-11.308-11.2l-131.86-131.862l-52.013 52.014l143.175 143.176Z"/></svg></a>';
      // echo '</span>';
      echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
  } else {
    echo 'No staff members found';
  }
  ?>
</div>