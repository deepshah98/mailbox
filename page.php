<?php get_header(); ?>

	<section class="jumbotron minor">
		<div class="container">
			<h1 class="col-lg-10 col-md-10 col-sm-12"><?php the_title(); ?></h1>
		</div>
	</section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<section id="post-<?php the_ID(); ?>" class="container main-container">
			<?php the_content(); ?>
		</section>

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

		</article>
		<!-- /article -->

	<?php endif; ?>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
