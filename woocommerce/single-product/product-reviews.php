<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$trustpilot_name = rwmb_meta( 'mbw_review_name' );
$trustpilot_sku = rwmb_meta( 'mbw_review_sku' );

if ( empty( $trustpilot_name ) || empty( $trustpilot_sku ) ) return '';
?>
<section id="productreviews" class="col-lg-8 col-md-8 col-sm-12 product-options product-detail-section">
    <h2>Product Reviews</h2>
    <div>
		<!-- TrustBox widget - Product Reviews MultiSource SEO (Beta) -->
		<a id="section1"></a>
		<div class="trustpilot-widget" data-locale="en-US" data-template-id="5763bccae0a06d08e809ecbb" data-businessunit-id="58d5726b0000ff00059f247c" data-style-height="500px" data-style-width="100%" data-theme="light" data-sku="<?php echo $trustpilot_sku; ?>" data-name="<?php echo $trustpilot_name; ?>">
			<div style="text-align:center;">
				<a href="https://www.trustpilot.com/review/mailboxworks.com" target="_blank" rel="noopener">Trustpilot</a>
			</div>
		</div>
		<!-- End TrustBox widget -->
		<p style="text-align: right;"><a href="#content">Return to Top</a></p>
    </div>
</section>
