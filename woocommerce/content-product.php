<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$freePedestals = [197, 158, 320];
$noDecimals = [197, 158, 320];
?>
<div class="col-md-4 col-sm-6 col-xs-12">
	<div class="category-card">
		<?php
			global $product;

			$href = get_the_permalink();
			$title = get_the_title();
			$category_ids = $product->category_ids;

			$isFreePedestal = false;
			$hasNoDecimals = false;

			foreach ($category_ids as $cid) {
				$isInPedestalArray = array_search($cid, $freePedestals);
				$isInNoDecimalsArray = array_search($cid, $noDecimals);

				if ($isInPedestalArray !== false) {
					$isFreePedestal = true;
				}

				if ($isInNoDecimalsArray !== false) {
					$hasNoDecimals = true;
				}
			}

			$message = $isFreePedestal ? 'free shipping & free pedestal' : 'free shipping';
			$price = $hasNoDecimals ? str_replace(',', '', number_format( $product->get_display_price(), 0) ) : number_format( (float)$product->get_display_price(), 2 );

			echo '<a href="' . $href . '" alt="' . $title . '">' . woocommerce_get_product_thumbnail() . '</a>';
			echo '<div class="product-title"><a href="' . $href . '" alt="' . $title . '">' . $title . '</a></div>';
			echo '<span class="mailbox-price"><span class="dollar-sign">$</span>' . $price . '</span>';
			if ($product->get_price() > 29.99) echo '<span class="free-shipping-product-card">' . $message . '</span>';
			else echo '<span class="free-shipping-product-card">&nbsp;</span>';
		?>
	</div>
</div>
