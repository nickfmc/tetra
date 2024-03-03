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
