<?php
  $default_sidebar_logo = get_template_directory_uri() . "/images/sidebar_logo.svg";
  $sidebar_logo = get_theme_mod('rolli_footer_logo', $default_footer_logo);
?>
<nav class="nav-sidebar" role="navigation">
  <?php rolli_nav(array('theme_location' => 'sidebar-menu')); ?>
  <div class="copyright" role="contentinfo">
    <hr class="sidebar-separator">
    <div class="sidebar-logo-wrapper">
      <img class="sidebar-logo" src="<?php echo $sidebar_logo; ?>">
    </div>
    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
  </div>
</nav>
