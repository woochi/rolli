<?php
/*
Template Name: Simple
*/
?>

<?php get_header(); ?>

<main role="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  
  <?php the_content(); ?>

<?php endwhile; ?>
<?php else: ?>

  <!-- Empty content-->

<?php endif; ?>

</main>

<?php get_footer(); ?>
