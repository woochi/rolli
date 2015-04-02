<!-- nav -->
<nav class="nav-header" role="navigation">
	<?php get_template_part("logo"); ?>
	<?php wp_nav_menu(array('theme_location' => 'header')); ?>
  <?php get_template_part("navigation_toggle"); ?>
</nav>

<div class="nav-sidebar right-off-canvas-menu">
  <?php rolli_nav(array(
    'theme_location' => 'sidebar'
  )); ?>
</div>
<!-- /nav -->
