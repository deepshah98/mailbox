<?php
/**
 * Single Product Availability, including microdata for SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$trustpilot_name = rwmb_meta( 'mbw_review_name' );
$trustpilot_sku = rwmb_meta( 'mbw_review_sku' );

if ( empty( $trustpilot_name ) || empty( $trustpilot_sku ) ) echo '';
else {
?>

<div class="ratings detail-section">
	<!-- TrustBox widget - Product Mini MultiSource (Beta) -->
	<div class="trustpilot-widget" style="text-align:center;" data-locale="en-US" data-template-id="577258fb31f02306e4e3aaf9" data-businessunit-id="58d5726b0000ff00059f247c" data-style-height="24px" data-style-width="100%" data-theme="light" data-sku="<?php echo $trustpilot_sku; ?>">
		<a href="https://www.trustpilot.com/review/mailboxworks.com" target="_blank">Trustpilot</a>
	</div>
	<!-- End TrustBox widget -->
	<div width="100%" style="text-align:center;">
		<a href="#productreviews">Read Customer Reviews</a>
	</div>
</div>
<?php } ?>
