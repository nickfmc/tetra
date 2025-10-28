<?php get_header(); ?>

<div class="o-layout-row">
  <main class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <header class="c-article-header">
        <?php // get_template_part( 'template-part/post/entry-meta' ); ?>
      </header>
      <!-- /article-header -->
      <article <?php post_class(); ?> role="article">
        <section class="editor-content  clearfix">
          <?php the_content(); ?>
          <?php if ( is_singular( 'staff_type' ) ) : ?>
            <?php
            // Get Tetra-Butes that are linked to this staff member
            $current_staff_id = get_the_ID();
            $tetra_bute_args = array(
              'post_type' => 'tetra_bute',
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'meta_query' => array(
                array(
                  'key' => 'linked_staff',
                  'value' => '"' . $current_staff_id . '"',
                  'compare' => 'LIKE'
                )
              )
            );
            $tetra_bute_query = new WP_Query($tetra_bute_args);
            
            if ($tetra_bute_query->have_posts()) : ?>
              <div class="c-staff-tetra-butes">
                <h3 class="u-light-blue">Tetra-bute Contributions</h3>
                <p>Discover the charitable initiatives and community programs that <?php echo get_the_title(); ?> champions:</p>
                <div class="c-staff-tetra-butes-grid">
                  <?php while ($tetra_bute_query->have_posts()) : $tetra_bute_query->the_post();
                    $tetra_bute_logo = get_field('logo', get_the_ID());
                    $tetra_bute_brief = get_field('brief_info', get_the_ID());
                    $tetra_bute_website = get_field('website_url', get_the_ID());
                    $tetra_bute_brand_color = get_field('brand_color', get_the_ID()) ?: '#88aebd';
                  ?>
                    <div class="c-staff-tetra-bute-item" style="border-left: 4px solid <?php echo esc_attr($tetra_bute_brand_color); ?>;">
                      <?php if ($tetra_bute_logo) : ?>
                        <div class="c-staff-tetra-bute-logo">
                          <img src="<?php echo esc_url($tetra_bute_logo['url']); ?>" alt="<?php echo esc_attr($tetra_bute_logo['alt']); ?>" />
                        </div>
                      <?php endif; ?>
                      <div class="c-staff-tetra-bute-content">
                        <h4><?php echo get_the_title(); ?></h4>
                        <?php if ($tetra_bute_brief) : ?>
                          <p><?php echo wp_kses_post($tetra_bute_brief); ?></p>
                        <?php endif; ?>
                        <div class="c-staff-tetra-bute-links">
                          <a href="/tetra-bute/" class="c-tetra-bute-link-small">Learn More</a>
                          <?php if ($tetra_bute_website) : ?>
                            <a href="<?php echo esc_url($tetra_bute_website); ?>" target="_blank" rel="noopener" class="c-tetra-bute-external-link">Visit Website</a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
              </div>
            <?php endif; ?>
            <div class="u-back-link"><p><a href="/about-us"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path d="M10 33c0-7.299 4.103-13.583 10-16.408A16.147 16.147 0 0 1 27 15c9.389 0 17 8.059 17 18"/><path d="m18 28l-8 5l-6-8"/></g></svg> Back to all team members </a></p></div>
          <?php endif; ?>
        </section> 
      </article>
    <?php endwhile; ?>
      <?php get_template_part( 'template-part/post/post-nav' ); ?>
    <?php else : ?>
      <?php get_template_part( 'template-part/post/not-found' ); ?>
    <?php endif; ?>

    <!-- if is staff_type single only -->
    
    
  </main>
</div>
<!-- /layout-row-->

<?php get_footer(); ?>
