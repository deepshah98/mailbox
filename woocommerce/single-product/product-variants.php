<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

if (method_exists($product, 'get_available_variations')) {
	$variants = $product->get_available_variations();
}

if ( isset($variants) && $variants && count($variants) > 0 ) { ?>

	<?php
		$span = min( 6, max( 3, ( 12 / count( $variants ) ) ) );
	?>

	<section class="col-lg-8 col-md-8 col-sm-12 product-detail-section">
        <h2>Finishes and Accents</h2>
        <div class="">
            <div class="alt-product-image-row" data-widget="carousel">

				<?php

					foreach( $variants as $v ) {
						$finish = $v['attributes']['attribute_finish'];
						$sku = $v['sku'];
						$imageAlt = $v['image']['alt'];
						$imageSrc = $v['image']['src'];

						echo sprintf(
							'<div class="category-card-wrapper col-sm-' . $span . '" data-carousel="card">
								<div class="category-card modal-image">
						            <img src="%s" alt="%s" />
						            <p class="alt-product-image">%s</p>
						            <p class="alt-product-sku">%s</p>
								</div>
					        </div>',
							esc_url( $imageSrc ),
							esc_attr( $imageAlt ),
							$finish,
							$sku
						);
					}
				?>
			</div>
		</div>
        <p class="instructions visible-xs-block visible-sm-block">
            Swipe left or right.
        </p>
	</section>
<?php } ?>
