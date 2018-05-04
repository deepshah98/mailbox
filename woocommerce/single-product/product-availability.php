<?php
/**
 * Single Product Availability, including microdata for SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$available = $product->is_in_stock();
$isNotStocked = rwmb_meta( 'mbw_product-not-stocked' );

?>
<div class="availability detail-section">
    <ul class="product-details no-bullets">
		<?php if ($product->get_shipping_class() == "free") { ?>
			<li class="free-shipping-tag"><i class="fa fa-truck"></i> Free Shipping</li>
		<?php } else { ?>
			<li>
				<i class="fa fa-truck"></i> Free shipping on orders over $30.00 <a href="#" data-type='modal' title="Free Shipping Details" data-modal-target="freeShippingAlert">details</a>
				<div class="modal-visible" id="freeShippingAlert">
					<h4>Shipping Time</h1>
					<ul>
						<li>"Ships in" time is the time it takes to process your order and leave the warehouse.</li>
						<li>These products are sent via Fedex Ground. Next Day Air and 2nd Day Air are available upon request at an additional charge.</li>
						<li>Transit time for this product is 1 to 5 days.</li>
					</ul>
					<h4>Free Shipping</h1>
					<ul>
						<li>All orders over $30.00 ship for free. Orders under $30.00 carry a flat rate shipping fee of $8.95</li>
						<li>Free shipping is for items being shipped to the US contiguous 48 states.</li>
						<li>If this item is shipping to HI, AK, or internationally there will an extra shipping fee.</li>
					</ul>
				</div>
			</li>
		<?php } ?>
		<li class="il-tax-tag"><?php dynamic_sidebar( 'widget-area-3' ); ?></li>
        <?php if ($isNotStocked !== "1" ) { ?><li class="availability-stock"><?php  echo ($product->is_in_stock()) ? "In Stock" : "Out of Stock"; ?></li><?php } ?>
		<?php do_action( 'mailboxworks_product_availability' ); ?>
    </ul>
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
