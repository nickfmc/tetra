<?php

/**
 * Tetra-Bute Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Enqueue block specific CSS
wp_enqueue_style('tetra-bute', get_stylesheet_directory_uri() . '/template-part/block/tetra-bute/tetra-bute.css', array(), '1.0.0');

// Create id attribute allowing for custom "anchor" value.
$id = 'tetra-bute-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-tetra-bute-block';
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
    'post_type' => 'tetra_bute',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_status' => 'publish'
  );
  $query = new WP_Query( $args );
  
  if ( $query->have_posts() ) {

    echo '<div class="c-tetra-bute-grid">';
    
    while ( $query->have_posts() ) {
      $query->the_post();
      global $post;
      
      // Get ACF fields with post ID
      $brief_info = get_field('brief_info', $post->ID);
      $logo = get_field('logo', $post->ID);
      $website_url = get_field('website_url', $post->ID);
      $linked_staff = get_field('linked_staff', $post->ID);
      $brand_color = get_field('brand_color', $post->ID) ?: '#88aebd';
      
      echo '<div class="c-tetra-bute-item" data-brand-color="' . esc_attr($brand_color) . '">';
      
      // Left side - Logo and main content
      echo '<div class="c-tetra-bute-left">';
      if ($logo) {
        echo '<div class="c-tetra-bute-logo">';
        echo '<img src="' . esc_url($logo['url']) . '" alt="' . esc_attr($logo['alt']) . '" />';
        echo '</div>';
      }
      
      echo '<div class="c-tetra-bute-content">';
      echo '<h3>' . get_the_title() . '</h3>';
      if ($brief_info) {
        echo '<p>' . wp_kses_post($brief_info) . '</p>';
      }
      
      if ($website_url) {
        echo '<a href="' . esc_url($website_url) . '" target="_blank" rel="noopener" class="c-tetra-bute-link">Visit ' . esc_html(get_the_title()) . '</a>';
      }
      echo '</div>';
      echo '</div>';
      
      echo '</div>';
    }
    
    echo '</div>';
    wp_reset_postdata();
  } else {
    if ($is_preview) {
      echo '<div class="c-tetra-bute-placeholder">';
      echo '<h3>Tetra-Bute Block</h3>';
      echo '<p>No Tetra-Butes found. Create some Tetra-Bute posts to display them here.</p>';
      echo '</div>';
    }
  }
  ?>
</div>