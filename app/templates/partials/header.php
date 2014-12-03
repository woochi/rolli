<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?>
    <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/images/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png" sizes="32x32">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/images/mstile-144x144.png">
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
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
