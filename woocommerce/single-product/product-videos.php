<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$vids = rwmb_meta( 'mbw_product_vids', 'type=oembed' );
if (empty($vids) || $vids === "<ul></ul>") return '';
preg_match_all('/<iframe.*?\/iframe>/', $vids, $match);
?>

<section class="col-lg-8 col-md-8 col-sm-12 product-options product-detail-section">
    <h2>Videos</h2>
    <?php foreach( $match as $v ) { ?>
        <?php foreach( $v as $u ) { ?>
            <div class="col-sm-6 col-xs-12">
                <?php echo preg_replace( '/(width|height)="\d*"\s/', "", $u ); ?>
            </div>
        <?php } ?>
    <?php } ?>
</section>
