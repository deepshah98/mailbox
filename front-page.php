<?php get_header(); ?>

	<section class="container top-banner">
		<div class="row">
			<div class="image-container hidden-xs col-sm-12">
				<span id="shippingDefaultBanner"></span>
				<span id="shippingDefaultBannerSale"></span>
				<span id="shippingDefaultBannerSubtext"></span>
				<img src="<?php echo get_template_directory_uri(); ?>/img/header-banner.jpg" alt="Free shipping on orders over $30.00" />
			</div>
			<div id="shippingMobileBanner" class="visible-xs-block banner-content col-xs-12"></div>
		</div>
	</section>

	<section class="jumbotron minor jumbotron--home hidden-sm hidden-xs">
		<div class="container">
			<h1 class="col-lg-12 col-md-12 col-sm-12"><?php the_title(); ?></h1>
		</div>

	</section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<section id="post-<?php the_ID(); ?>" class="container main-container">
			<div class='home-page'>
				<?php the_content(); ?>
			</div>
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

<section class="container">
	<section class="row  hidden-sm hidden-xs">
		<div class="col-lg-12 bottom-banner image-container">
			<img src="<?php echo get_template_directory_uri(); ?>/img/footer-banner.jpg" alt="Your trusted source, since 1989. We stand behind every product we sell." />
		</div>
	</section>
</section>

<script type="text/javascript">
	function getSuffix(date) {
		if (date === 11 || date === 12 || date === 13) return 'th';

		var ones = date%10;

		switch(ones) {
			case 1:
				return 'st';
			case 2:
				return 'nd';
			case 3:
				return 'rd';
			default:
				return 'th';
		}
	}

	var months = ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'June', 'Jul.', 'Aug.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'];
	var today = new Date();
	var dateAsString = months[today.getMonth()] + ' ' + today.getDate() + getSuffix(today.getDate());

	jQuery('#shippingMobileBanner').html('<i class="fa fa-tag"></i> Free shipping thru ' + dateAsString+ ' on orders over $30');
	jQuery('#shippingDefaultBanner').html('Save Big Now <span class="red-font">PLUS</span> free shipping thru ' + dateAsString);
	jQuery('#shippingDefaultBannerSubtext').html('on orders over $30.00');
</script>

<?php get_footer(); ?>