<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$specs = rwmb_meta( 'mbw_product-specs-adv' );
if (empty($specs)) return '';
?>
<div class="col-md-6 col-sm-12">
	<h3>Specs</h3>
    <?php foreach ($specs as $s) { ?>
		<div class="spec-image click-to-expand modal-image">
            <img src="<?php echo $s['full_url']; ?>" alt="<?php echo $b['name']; ?>" />
        </div>
    <?php } ?>
</div>
