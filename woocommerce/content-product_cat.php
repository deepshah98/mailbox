<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="col-md-4 col-sm-6 col-xs-12">
	<div class="category-card">
		<?php
			$href = get_term_link( $category, 'product_cat' );
			$title = $category->name;

			// Getting image;
			$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
			if ( $thumbnail_id ) {
				$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
				$image = $image[0];
			} else {
				$image = wc_placeholder_img_src();
			};
			$image = str_replace( ' ', '%20', $image );

			echo '<a href="' . $href . '" alt="' . $title . '"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" /></a>';
			echo '<div class="product-title"><a href="' . $href . '" alt="' . $title . '">' . $title . '</a></div>';
			echo '<span class="product-count">' . $category->count . ' Products</span>';
		?>
	</div>
</div>
