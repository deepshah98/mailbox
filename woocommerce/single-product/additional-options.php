<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$link_text = rwmb_meta( 'mbw_additional_options_text' );
$content = rwmb_meta( 'mbw_additional_options_content' );
if (empty($content)) return '';
?>
<section id="additional-product-options" class="col-lg-8 col-md-8 col-sm-12 product-options product-detail-section" id="product-options">
    <h2>Aditional Product Options</h2>
    <div>
		<?php echo $content; ?>
    </div>
</section>
