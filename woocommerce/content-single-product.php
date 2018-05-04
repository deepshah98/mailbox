<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<section class="container main-container" itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>">
	<div class="row">

		<?php
			/**
			 * woocommerce_before_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<section class="col-lg-4 col-md-4 col-sm-6 details-container" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

			<?php
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked mailboxworks_get_product_availability - 15
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>

		</section><!-- .summary -->

		<section class="col-lg-4 col-md-4 col-sm-12 checkout-container">
			<?php
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 */
				do_action( 'woocommerce_add_to_cart_form' );
			?>
		</section>
	</div>
	<div class="row">
		<?php do_action( 'mailboxworks_get_variations' ); ?>

		<?php do_action( 'mailboxworks_get_product_options' ); ?>

		<section class="col-lg-8 col-md-8 col-sm-12 product-detail-section" id="product-details">
            <h2>Product Details</h2>
			<?php do_action( 'mailboxworks_product-details' ) ?>
			<div class="row">
				<?php do_action( 'mailboxworks_product-files' ); ?>
			</div>
		</section>

		<?php do_action( 'mailboxworks_product-media' ); ?>

		<?php do_action( 'mailboxworks_product-review' ); ?>

		<?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>
</section><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
