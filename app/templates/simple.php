<?php
/*
Template Name: Simple
*/
?>

<?php get_header(); ?>
<?php get_template_part('navigation'); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <?php the_content(); ?>

<?php endwhile; ?>
<?php else: ?>

  <!-- Empty content-->

<?php endif; ?>

<?php get_footer(); ?>
