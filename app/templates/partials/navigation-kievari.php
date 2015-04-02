<nav class="nav-header">
  <?php get_template_part("logo"); ?>
  <?php rolli_nav(array(
    'theme_location' => 'kievari'
  )); ?>
  <?php get_template_part("navigation_toggle"); ?>
</nav>

<div class="nav-sidebar right-off-canvas-menu">
  <?php rolli_nav(array(
    'theme_location' => 'kievari',
    'menu_class' => 'sidebar-nav-list'
  )); ?>
</div>
