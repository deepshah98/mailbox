<?php get_header(); ?>

	<div id="container">
		<div id="content" role="main">
			<section class="jumbotron minor">
				<div class="container">
					<h1 class="col-lg-10 col-md-10 col-sm-12"><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
				</div>
			</section>
			<!-- section -->
			<section class="container main-container">

				<section class="row category-page-row">
					<?php get_template_part('loop'); ?>
				</section>

				<?php get_template_part('pagination'); ?>


			</section>
			<!-- /section -->
		</div>
	</div>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
