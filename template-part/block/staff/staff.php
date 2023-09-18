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
      echo '<div class="c-staff-img">';
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'full');
      } else {
        echo '<img src="' . bloginfo( 'template_url' ) . '/img/placeholder.png" alt="placeholder img" />';
      }
      echo '</div>';
      echo '<div class="c-staff-name">';
      echo '<h5>' . get_the_title() . '</h5>';
      echo '</div>';
      if ( get_field( 'designation', get_the_ID() ) ) {
        echo '<div class="c-staff-title">' . get_field( 'designation', get_the_ID() ) . '</div>';
      }
     
      echo '<span class="c-staff-member-trigger c-btn-text">';
      echo '<a class="popup-modal" href="#pop-' . $post->post_name . '">View Bio</a>';
      echo '</span>';
      echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
  } else {
    echo 'No staff members found';
  }
  ?>
</div>