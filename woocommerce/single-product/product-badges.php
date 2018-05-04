<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$badges = rwmb_meta( 'mbw_product-badges-adv' );
if (empty($badges)) return '';
?>
<div class="badges">
    <?php foreach ($badges as $b) { ?>
        <img src="<?php echo $b['url']; ?>" alt="<?php echo $b['name']; ?>" />
    <?php } ?>
</div>
