<?php

/**
 * Tetra-Bute Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Enqueue block specific CSS and JS
wp_enqueue_style('tetra-bute', get_stylesheet_directory_uri() . '/template-part/block/tetra-bute/tetra-bute.css', array(), '1.0.0');
wp_enqueue_script('tetra-bute-js', get_stylesheet_directory_uri() . '/template-part/block/tetra-bute/tetra-bute.js', array('jquery'), '1.0.0', true);

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
  // Get all provinces for filtering
  $provinces = get_terms(array(
    'taxonomy' => 'province',
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC',
  ));
  
  if (!is_wp_error($provinces) && !empty($provinces)) : ?>
    <div class="c-tetra-bute-filters">
      <!-- Centralized tooltip display area -->
      <div class="c-province-tooltip-display">
        <span class="c-province-tooltip-text"></span>
      </div>
      
      <div class="c-province-filters">
        <!-- <button class="c-province-filter active" data-province="all">
          <svg class="c-province-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="45" fill="currentColor"/>
          </svg>
          <span class="c-province-label">All Provinces</span>
        </button> -->
        
        <?php foreach ($provinces as $province) : 
          $svg_media_id = get_term_meta($province->term_id, 'svg_media_id', true);
          $province_color = get_term_meta($province->term_id, 'svg_color', true) ?: '#88aebd';
          $tooltip_text = get_term_meta($province->term_id, 'tooltip_text', true);
          // Use custom tooltip text if available, otherwise fall back to province name
          $tooltip_content = !empty($tooltip_text) ? $tooltip_text : $province->name;
        ?>
          <button class="c-province-filter" data-province="<?php echo esc_attr($province->slug); ?>" data-tooltip="<?php echo esc_attr($tooltip_content); ?>" style="--province-color: <?php echo esc_attr($province_color); ?>">
            <?php 
            // Use custom SVG from media library if available, otherwise fallback to default circle
            $custom_svg = get_province_custom_svg($province->term_id);
            if ($custom_svg) {
              echo $custom_svg;
            } else {
              // Fallback if no custom SVG is set
              echo '<svg class="c-province-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="50" cy="50" r="45" fill="currentColor"/>
                    </svg>';
            }
            ?>
            <span class="c-province-label"><?php echo esc_html($province->name); ?></span>
          </button>
        <?php endforeach; ?>
      </div>
      
      <!-- Clear filters link (hidden by default) -->
      <div class="c-clear-filters-container" style="display: none;">
        <button class="c-clear-filters" type="button">
          <span>Clear filter</span>
          <span class="c-clear-filters-icon">×</span>
        </button>
      </div>
    </div>
  <?php endif; ?>

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
      
      // Get provinces for this post
      $post_provinces = get_the_terms($post->ID, 'province');
      $province_slugs = array();
      if ($post_provinces && !is_wp_error($post_provinces)) {
        foreach ($post_provinces as $province) {
          $province_slugs[] = $province->slug;
        }
      }
      $province_classes = !empty($province_slugs) ? ' ' . implode(' ', array_map(function($slug) { return 'province-' . $slug; }, $province_slugs)) : '';
      
      echo '<div class="c-tetra-bute-item' . esc_attr($province_classes) . '" data-brand-color="' . esc_attr($brand_color) . '" data-provinces="' . esc_attr(implode(',', $province_slugs)) . '">';
      
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
      echo '<h3>Tetra-bute Block</h3>';
      echo '<p>No Tetra-butes found. Create some Tetra-bute posts to display them here.</p>';
      echo '</div>';
    }
  }
  ?>
</div>