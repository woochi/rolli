<?php

$default_header_logo = get_template_directory_uri() . "/images/header_logo.svg";
$header_logo = get_theme_mod('rolli_theme_options[header_logo]', $default_header_logo);

?>
<!-- nav -->
<nav class="nav-header" role="navigation">
	<h1 class="logo" style="background:url('<?php echo $header_logo; ?>');">
  <a href="<?php echo get_home_url(); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
	<?php rolli_nav(array(
    'theme_location' => 'header-menu',
    'collapsable' => true
  )); ?>
</nav>
<!-- /nav -->
