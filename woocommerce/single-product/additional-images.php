<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$attachment_ids = $product->get_gallery_attachment_ids();

if (!$attachment_ids) return '';
?>

<section class="col-lg-8 col-md-8 col-sm-12 product-options product-detail-section">
    <h2>Additional Images</h2>

    <?php do_action( 'woocommerce_product_thumbnails' ); ?>

</section>
