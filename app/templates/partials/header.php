<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
  <?php
    $body_class = "";
    if (has_post_thumbnail() && !is_home()):
      $body_class .= "has-image";
    endif;
  ?>
	<body <?php body_class($body_class); ?>>

    <!-- <?php get_template_part('pagination'); ?> -->

		<div class="wrapper">
      <div class="content-wrapper">
        <?php get_template_part('navigation', 'sidebar'); ?>
        <div class="content">
		      <?php get_template_part('navigation'); ?>
          <main role="main">
