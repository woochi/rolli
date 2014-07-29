<?php
/*
Template Name: Simple
*/
?>

<?php get_header(); ?>

<main>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<?php the_content(); ?>
			<?php edit_post_link(); ?>

	<?php endwhile; ?>
	<?php endif; ?>

	</section>
	<!-- /section -->
</main>

<?php get_footer(); ?>
