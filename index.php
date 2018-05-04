<?php get_header(); ?>

	<div id="container">
		<div id="content" role="main">
			<!-- section -->
			<section class="container main-container">

				<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

			</section>
			<!-- /section -->
		</div>
	</div>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
