<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  
  <?php // Are you using REAL FAVICON GENERATOR!? You should. If so...  ?>
  <?php // Put generated code in favicon-head.php file; then uncomment line below ?>
  <?php // get_template_part( 'template-part/favicon-head' ); ?>

  <?php // other html head stuff (before WP/theme scripts are loaded) ------- ?>

  <?php wp_head(); // wordpress head functions -- DONOTREMOVE ?>

  <?php // START Google Analytics here ?>
  <?php // END Analytics ?>
</head>

<body <?php body_class(pretty_body_class()); ?> itemscope itemtype="https://schema.org/WebPage">

  <header id="c-page-header" class="o-section c-page-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
    <div class="o-wrapper-wide  u-relative">
      <?php get_template_part( 'template-part/header/logo' ); ?>
      <?php get_template_part( 'template-part/navigation/nav-main' ); ?>
      <?php get_template_part( 'template-part/navigation/nav-tertiary' ); ?>
      <div class="c-modal-nav-button-wrap">
        <a class="toggle hc-nav-trigger mobile-nav" href="#" role="button" aria-label="Open Menu" aria-controls="hc-nav-1" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M20 7H4m16 5H4m16 5H4"/></svg>
      </a>
      </div>
    </div>
    <!-- /o-wrapper-wide-->
  </header> 
  <!-- /c-page-header -->
