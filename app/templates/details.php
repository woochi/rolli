<?php
/*
Template Name: Detail
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <?php
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
  ?>

  <div class="hero" style="background-image: url(<?php echo $image; ?>);">
    <div class="hero-wrap">
      <div class="hero-content">
        <div class="hero-title"><? the_title(); ?></div>
      </div>
    </div>
  </div>

  <article class="article">
    <?php the_content(); ?>
  </article>

<?php endwhile; ?>
<?php else: ?>

  <!-- Empty content-->

<?php endif; ?>

<?php get_footer(); ?>
