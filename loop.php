<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4', 'col-sm-6', 'col-xs-12'); ?>>

		<div class="category-card">


			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(array(260,260)); // Declare pixel size you need inside the array ?>
				</a>

			<?php endif; ?>
			<!-- /post thumbnail -->

			<!-- post title -->
			<h2>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h2>
			<!-- /post title -->

		<?php // html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>

		<?php // edit_post_link(); ?>

		</div>

	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, there are 0 results matching that search.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
