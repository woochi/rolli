<!-- nav -->
<nav class="nav-header" role="navigation">
	<h1 class="logo logo-header">
    <a href="<?php echo get_home_url(); ?>">
      <?php echo get_bloginfo('name'); ?>
    </a title="Siirry etusivulle">
  </h1>
	<?php wp_nav_menu(array('theme_location' => 'header')); ?>
  <a class="nav-toggle">Valikko <span class="icon-menu"></span></a>
</nav>
<!-- /nav -->
